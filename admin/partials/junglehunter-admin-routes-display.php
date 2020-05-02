<?php
$name = '';
$start = '';
$url = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $name = $_POST['name'];
    if (!$name || strlen($name) == 0 || strlen($name) > 100) {
        $errors['name'] = 'The name of the route needs to be at least 1 and max 100 characters!';
    }

    $start = $_POST['start'];
    if (!$start || strlen($start) == 0 || strlen($start) > 100) {
        $errors['start'] = 'The start of the route needs to be at least 1 and max 100 characters!';
    }

    $url = $_POST['url'];
    if (!$url || strlen($url) == 0 || strlen($url) > 255) {
        $errors['url'] = 'The url of the route needs to be at least 1 and max 255 characters!';
    }

    $description = $_POST['description'];
    if (!$description || strlen($description) == 0 || strlen($description) > 255) {
        $errors['description'] = 'The description of the route needs to be at least 1 and max 255 characters!';
    }

    if (empty($errors)) {
        JungleHunter_Database::junglehunter_insert_route($name, $start, $url, $description);
        $name = '';
        $start = '';
        $url = '';
        $description = '';
    }
}
?>

<div class="wrap">
    <div id="junglehunter-input">
        <h1>Insert Route:</h1>
        <form action="<?php menu_page_url("junglehunter-routes") ?>" method="post">
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
                          placeholder="A small description of the Route"><?php echo $description ?></textarea>
            </div>
            <input type="submit" value="Create">
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
    <table id="junglehunter-table">
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
            echo '<tr class="junglehunter-pointer">';
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
