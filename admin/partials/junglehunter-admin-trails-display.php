<?php
function validateBody(&$name, &$length, &$route_id, $routes) {
    $errors = array();

    // Validate name if it is: empty, too long, already existing
    if (!isset($_POST['name']) || (strlen(trim($_POST['name'])) == 0)) {
        $errors['name'] = 'The name of the Trail cannot be empty!';
    } else if (strlen(trim($_POST['name'])) > 100) {
        $errors['name'] = 'The name of the trail is too long!';
    } else {
        $row = JungleHunter_Database::junglehunter_get_trail_by_name(trim($_POST['name']));
        if ($row != NULL && isset($_POST['id']) && $row->trail_id != $_POST['id']) {
            $errors['name'] = 'This name already exists!';
        }
    }

    // Validate length if it is: empty, a number
    if (!isset($_POST['length']) || (strlen(trim($_POST['length'])) == 0)) {
        $errors['length'] = 'The length of the trail cannot be empty!';
    } else if (!is_numeric(str_replace(',', '.', $_POST['length']))) {
        $errors['length'] = 'The length of the trail needs to be a number!';
    }

    // Validate route if it is: empty, exists
    if (!isset($_POST['route_id'])) {
        $errors['route'] = 'The route of the trail needs to be set!';
    } else if (in_array($route_id, $routes, true)) {
        $errors['route'] = 'This route does not exist!';
    }

    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }
    if (isset($_POST['length'])) {
        $length = trim($_POST['length']);
    }
    if (isset($_POST['route_id'])) {
        $route_id = trim($_POST['route_id']);
    }

    return $errors;
}

$id = $name = $length = $route_id = $response = '';
$routes = JungleHunter_Database::junglehunter_get_routes();
// Handle form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
    if ($_POST['_method'] == 'POST') {
        // Create trail
        // Get errors
        $errors = validateBody($name, $length, $route_id, $routes);
        // Check if everything is valid if yes insert, set a response
        if (empty($errors)) {
            JungleHunter_Database::junglehunter_insert_trail(
                $name,
                floatval(str_replace(',', '.', $length)),
                $route_id
            );
            $response = 'A new Trail was created!';
            $name = $length = $route_id = '';
        }
    } else if ($_POST['_method'] == 'DELETE' && isset($_POST['id'])) {
        // Delete trail
        // Try to delete and output based on the changed rows
        $response = JungleHunter_Database::junglehunter_delete_trail(
            $_POST['id']
        ) ? 'The Trail was deleted!' : 'This Trail does not exist!';
    } else if ($_POST['_method'] == 'PUT' && isset($_POST['id'])) {
        // Update trail
        // Get errors
        $errors = validateBody($name, $length, $route_id, $routes);
        $id = $_POST['id'];
        // Check if everything is valid if yes update, set a response based on the updated rows
        if (empty($errors)) {
            $is_updated = JungleHunter_Database::junglehunter_update_trail(
                $id,
                $name,
                floatval(str_replace(',', '.', $length)),
                $route_id
            );
            $response = $is_updated ? 'The Trail was updated!' : 'Nothing was changed!';
            $id = $name = $length = $route_id = '';
        }
    }
}

?>

<div class="wrap">
    <?php if (isset($response) && $response != '')
        echo "<div id='junglehunter-status-bar'>$response</div>" ?>
    <div id="junglehunter-input">
        <h1>Create new Trail:</h1>
        <form action="<?php menu_page_url("junglehunter-trails") ?>" method="post" id="junglehunter-form">
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-name">Name:</label>
                <input type="text" id="junglehunter-trail-name" name="name" placeholder="A name for the Trail"
                       value="<?php echo $name ?>"
                       class="<?php if (isset($errors['name']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['name']))
                        echo $errors['name'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-length">Length:</label>
                <input type="text" id="junglehunter-trail-length" name="length"
                       placeholder="The length of the trail in kilometer"
                       value="<?php echo $length ?>"
                       class="junglehunter-number-input <?php if (isset($errors['length']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['length']))
                        echo $errors['length'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-route">Route:</label>
                <select name="route_id" id="junglehunter-trail-route"
                        class="<?php if (isset($errors['route']))
                            echo 'junglehunter-red-border' ?>">
                    <?php
                    $hasSelected = false;
                    foreach ($routes as $single_route) {
                        $is_selected = '';
                        if ($single_route->route_id == $route_id) {
                            $is_selected = 'selected';
                            $hasSelected = true;
                        }
                        echo "<option $is_selected value='$single_route->route_id'>$single_route->route_name</option>";
                    }
                    ?>
                    <option value="" <?php echo($hasSelected ? '' : 'selected') ?> disabled hidden>
                        The Route that the Trail belongs to
                    </option>
                </select>
                <span class="junglehunter-error-message"><?php if (isset($errors['route']))
                        echo $errors['route'] ?>
                </span>
            </div>
            <div class="junglehunter-buttons">
                <?php $is_creating = $id == '' ?>
                <input type="button" value="Cancel" id="junglehunter-cancel" class="junglehunter-button">
                <input type="submit" value="Delete" id="junglehunter-delete" <?php if ($is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
                <input type="submit" value="Save" id="junglehunter-save" <?php if ($is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
                <input type="submit" value="Create" id="junglehunter-create" <?php if (!$is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
            </div>
            <input type="hidden" id="junglehunter-id" name="id"
                   class="junglehunter-button" value="<?php echo $id ?>">
            <input type="hidden" value="POST" id="junglehunter-method" name="_method">
        </form>
    </div>
    <h1>All Trails:</h1>
    <table id="junglehunter-table" class="junglehunter-unselectable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Length in kilometer</th>
            <th>Route</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $trails = JungleHunter_Database::junglehunter_get_trails();
        foreach ($trails as $trail) {
            $selected_class = $trail->trail_id == $id ? ' junglehunter-selected-table' : '';
            echo "<tr class='junglehunter-trail-tr$selected_class'>";
            echo "<td data-id='$trail->trail_id'>$trail->trail_name</td>";
            echo '<td>' . str_replace('.', ',', $trail->length) . '</td>';
            echo "<td data-id='$trail->route_id'>$trail->route_name</td>";
            echo '<tr/>';
        }
        ?>
        </tbody>
    </table>
</div>
