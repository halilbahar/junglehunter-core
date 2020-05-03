<?php
$name = '';
$start = '';
$url = '';
$description = '';
$response = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
    if ($_POST['_method'] == 'POST') {
        $errors = array();
        if (!isset($_POST['name']) || (isset($_POST['name']) && (strlen($_POST['name']) == 0 || strlen($_POST['name']) > 100))) {
            $name = $_POST['name'];
            $errors['name'] = 'The name of the route needs to be at least 1 and max 100 characters!';
        }

        if (!isset($_POST['start']) || (isset($_POST['start']) && (strlen($_POST['start']) == 0 || strlen($_POST['start']) > 100))) {
            $start = $_POST['start'];
            $errors['start'] = 'The start of the route needs to be at least 1 and max 100 characters!';
        }

        if (!isset($_POST['url']) || (isset($_POST['url']) && (strlen($_POST['url']) == 0 || strlen($_POST['url']) > 255))) {
            $url = $_POST['url'];
            $errors['url'] = 'The url of the route needs to be at least 1 and max 255 characters!';
        }

        if (!isset($_POST['description']) || (isset($_POST['description']) && (strlen($_POST['description']) == 0 || strlen($_POST['description']) > 255))) {
            $description = $_POST['description'];
            $errors['description'] = 'The description of the route needs to be at least 1 and max 255 characters!';
        }

        if (empty($errors)) {
            JungleHunter_Database::junglehunter_insert_route($name, $start, $url, $description);
            $response = 'A new Route was created!';
            $name = '';
            $start = '';
            $url = '';
            $description = '';
        }
    } else if ($_POST['_method'] == 'DELETE') {
        $name = $_POST['name'];
        if (isset($name)) {
            JungleHunter_Database::junglehunter_delete_route($name);
            $response = 'The route was deleted!';
            $name = '';
        }
    }
}
?>

<div class="wrap">
        <?php if ($response != '') echo "<div>$response</div>" ?>
    <div id="junglehunter-input">
        <h1>Insert Route:</h1>
        <form action="<?php menu_page_url("junglehunter-routes") ?>" method="post" id="junglehunter-form">
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-name">Name:</label>
                <input type="text" id="junglehunter-route-name" name="name" placeholder="A name for the Route"
                       value="<?php echo $name ?>">
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-start">Start:</label>
                <input type="text" id="junglehunter-route-start" name="start" placeholder="The start of the Route"
                       value="<?php echo $start ?>">
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-url">Url:</label>
                <input type="text" id="junglehunter-route-url" name="url" placeholder="The Url of the Route?"
                       value="<?php echo $url ?>">
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-route-description">Description:</label>
                <textarea id="junglehunter-route-description" name="description"
                          placeholder="A small description of the Route" rows="3"><?php echo $description ?></textarea>
            </div>
            <input type="submit" value="Create" id="junglehunter-create">
            <input type="button" value="Save" id="junglehunter-save" disabled>
            <input type="submit" value="Delete" id="junglehunter-delete" disabled>
            <input type="button" value="Cancel" id="junglehunter-route-cancel">
            <input type="hidden" id="junglehunter-method" name="_method" value="POST">
        </form>
        <?php
        if (isset($errors)) {
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
        }
        ?>
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
