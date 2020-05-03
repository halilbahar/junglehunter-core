<?php
$name = $start = $url = $description = $response = '';
function validateBody() {
    $errors = array();
    if (!isset($_POST['name']) || (isset($_POST['name']) && (strlen($_POST['name']) == 0 || strlen($_POST['name']) > 100))) {
        $errors['name'] = 'The name of the route needs to be at least 1 and max 100 characters!';
    }

    if (!isset($_POST['start']) || (isset($_POST['start']) && (strlen($_POST['start']) == 0 || strlen($_POST['start']) > 100))) {
        $errors['start'] = 'The start of the route needs to be at least 1 and max 100 characters!';
    }

    $regex = '/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}\S*/';
    if (!isset($_POST['url']) || (isset($_POST['url']) && preg_match($regex, $_POST['url'], $matches, PREG_OFFSET_CAPTURE, 0) == 0)) {
        $errors['url'] = 'The url of the route is invalid!';
    }else if (isset($_POST['url']) && (strlen($_POST['url']) == 0 || strlen($_POST['url']) > 255)) {
        $errors['url'] = 'The url is too long!';
    }

    if (!isset($_POST['description']) || (isset($_POST['description']) && (strlen($_POST['description']) == 0 || strlen($_POST['description']) > 255))) {
        $errors['description'] = 'The description of the route needs to be at least 1 and max 255 characters!';
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
    if ($_POST['_method'] == 'POST') {
        $errors = validateBody();
        $name = $_POST['name'];
        $start = $_POST['start'];
        $url = $_POST['url'];
        $description = $_POST['description'];
        if (empty($errors)) {
            JungleHunter_Database::junglehunter_insert_route($name, $start, $url, $description);
            $response = 'A new Route was created!';
            $name = $start = $url = $description = '';
        }

    } else if ($_POST['_method'] == 'DELETE' && isset($_POST['original_name'])) {
        $response = JungleHunter_Database::junglehunter_delete_route($_POST['original_name']) ? 'The route was deleted!' : 'This route does not exist!';

    } else if ($_POST['_method'] == 'PUT' && $_POST['original_name']) {
        $errors = validateBody();
        if (empty($errors)) {
            $isUpdated = JungleHunter_Database::junglehunter_update_route($_POST['original_name'], $_POST['name'], $_POST['start'], $_POST['url'], $_POST['description']);
            $response = $isUpdated ? 'The Route was updated!' : 'Nothing was changed!';
        }
    }
}
?>

<div class="wrap">
    <div><?php echo $response ?></div>
    <div id="junglehunter-input">
        <h1>Insert Route:</h1>
        <form action="<?php menu_page_url("junglehunter-routes") ?>" method="post" id="junglehunter-form">
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-name">Name:</label>
                <input type="text" id="junglehunter-route-name" name="name" placeholder="A name for the Route"
                       value="<?php echo $name ?>"
                       class="<?php if (isset($errors['name']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['name']))
                        echo $errors['name'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-start">Start:</label>
                <input type="text" id="junglehunter-route-start" name="start" placeholder="The start of the Route"
                       value="<?php echo $start ?>"
                       class="<?php if (isset($errors['start']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['start']))
                        echo $errors['start'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-url">Url:</label>
                <input type="text" id="junglehunter-route-url" name="url" placeholder="The Url of the Route?"
                       value="<?php echo $url ?>"
                       class="<?php if (isset($errors['url']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message"><?php if (isset($errors['url']))
                        echo $errors['url'] ?></span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-description">Description:</label>
                <textarea id="junglehunter-route-description" name="description"
                          placeholder="A small description of the Route" rows="3"
                          class="<?php if (isset($errors['description']))
                              echo 'junglehunter-red-border' ?>"><?php echo $description ?></textarea>
                <span class="junglehunter-error-message"><?php if (isset($errors['description']))
                        echo $errors['description'] ?></span>
            </div>
            <div class="junglehunter-buttons">
                <input type="button" value="Cancel" id="junglehunter-route-cancel" class="junglehunter-button">
                <input type="submit" value="Delete" id="junglehunter-delete" disabled class="junglehunter-button">
                <input type="submit" value="Save" id="junglehunter-save" disabled class="junglehunter-button">
                <input type="submit" value="Create" id="junglehunter-create" class="junglehunter-button">
            </div>
            <input type="hidden" id="junglehunter-original-unique-field" name="original_name"
                   class="junglehunter-button">
            <input type="hidden" value="POST" id="junglehunter-method" name="_method" class="junglehunter-button">
        </form>
    </div>
    <h1>Registered Routes:</h1>
    <table id="junglehunter-table" class="junglehunter-unselectable">
        <thead>
        <tr>
            <th>Router Name</th>
            <th>Start</th>
            <th>Url</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $routes = JungleHunter_Database::junglehunter_get_routes();
        foreach ($routes as $route) {
            echo '<tr class="junglehunter-route-tr">';
            echo "<td>$route->route_name</td>";
            echo "<td>$route->start</td>";
            echo "<td>$route->url</td>";
            echo "<td>$route->description</td>";
            echo '<tr/>';
        }
        ?>
        </tbody>
    </table>
</div>
