<?php
function validateBody(&$name, &$length, &$route, $routes) {
    $errors = array();

    // Validate name if it is: empty, too long, already existing
    if (!isset($_POST['name']) || (strlen(trim($_POST['name'])) == 0)) {
        $errors['name'] = 'The name of the Trail cannot be empty!';
    } else if (strlen(trim($_POST['name'])) > 100) {
        $errors['name'] = 'The name of the trail is too long!';
    } else {
        $row = JungleHunter_Database::junglehunter_get_trail_by_name(trim($_POST['name']));
        if ($row != NULL && isset($_POST['original_name']) && $row->trail_name != $_POST['original_name']) {
            $errors['name'] = 'This name already exists!';
        }
    }

    // Validate length if it is: empty, a number
    if (!isset($_POST['length']) || (strlen(trim($_POST['length'])) == 0)) {
        $errors['length'] = 'The length of the trail cannot be empty!';
    } else if (!is_numeric(str_replace(',', '.', $_POST['length']))) {
        var_dump($_POST);
        $errors['length'] = 'The length of the trail needs to be a number!';
    }

    // Validate route if it is: empty, exists
    if (!isset($_POST['route'])) {
        $errors['route'] = 'The route of the trail needs to be set!';
    } else if (in_array($route, $routes, true)) {
        $errors['route'] = 'This route does not exist!';
    }

    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }
    if (isset($_POST['length'])) {
        $length = trim($_POST['length']);
    }
    if (isset($_POST['route'])) {
        $route = trim($_POST['route']);
    }

    return $errors;
}

$name = $original_name = $length = $route = '';
$routes = JungleHunter_Database::junglehunter_get_routes();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
    if ($_POST['_method'] == 'POST') {
        $errors = validateBody($name, $length, $route, $routes);
        if (empty($errors)) {
            JungleHunter_Database::junglehunter_insert_trail($name, floatval(str_replace(',', '.', $length)), $route);
            $name = $length = $route = '';
        }
    } else if ($_POST['_method'] == 'DELETE' && isset($_POST['original_name'])) {
        $response = JungleHunter_Database::junglehunter_delete_trail($_POST['original_name']) ? 'The trail was deleted!' : 'This trail does not exist!';
    }

}

?>

<div class="wrap">
    <div id="junglehunter-input">
        <h1>Insert Trail:</h1>
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
                       oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*),/g, '$1');"
                       value="<?php echo $length ?>"
                       class="<?php if (isset($errors['length']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['length']))
                        echo $errors['length'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-route">Route:</label>
                <select name="route" id="junglehunter-trail-route"
                        class="<?php if (isset($errors['route']))
                            echo 'junglehunter-red-border' ?>">
                    <?php
                    $hasSelected = false;
                    foreach ($routes as $single_route) {
                        $is_selected = '';
                        if ($single_route->route_name == $route) {
                            $is_selected = 'selected';
                            $hasSelected = true;
                        }
                        echo "<option $is_selected value='$single_route->route_name'>$single_route->route_name</option>";
                    }
                    ?>
                    <option value="" <?php echo($hasSelected ? '' : 'selected') ?> disabled hidden>
                        The Route that the Trail belongs to
                    </option>
                </select>
                <span class="junglehunter-error-message"><?php if (isset($errors['route']))
                        echo $errors['route'] ?></span>
            </div>
            <div class="junglehunter-buttons">
                <?php $is_creating = $original_name == '' ?>
                <input type="button" value="Cancel" id="junglehunter-cancel" class="junglehunter-button">
                <input type="submit" value="Delete" id="junglehunter-delete" <?php if ($is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
                <input type="submit" value="Save" id="junglehunter-save" <?php if ($is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
                <input type="submit" value="Create" id="junglehunter-create" <?php if (!$is_creating)
                    echo 'disabled' ?> class="junglehunter-button">
            </div>
            <input type="hidden" id="junglehunter-original-unique-field" name="original_name"
                   class="junglehunter-button" value="<?php echo $original_name ?>">
            <input type="hidden" value="POST" id="junglehunter-method" name="_method">
        </form>
    </div>
    <h1>Registered Routes:</h1>
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
            echo '<tr class="junglehunter-trail-tr">';
            echo "<td>$trail->trail_name</td>";
            echo '<td>' . str_replace('.', ',', $trail->length) . '</td>';
            echo "<td>$trail->route_name</td>";
            echo '<tr/>';
        }
        ?>
        </tbody>
    </table>
</div>
