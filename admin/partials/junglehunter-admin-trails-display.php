<?php
$name = '';
$length = '';
$route = '';
$routes = JungleHunter_Database::junglehunter_get_routes();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $name = $_POST['name'];
    if (!$name || strlen($name) == 0 || strlen($name) > 100) {
        $errors['name'] = 'The name of the trail needs to be at least 1 and max 100 characters!';
    }

    $length = $_POST['length'];
    $lengthConverted = str_replace(',', '.', $length);
    if (!$length || !is_numeric($lengthConverted) || $lengthConverted <= 0) {
        $errors['start'] = 'The length of the trail needs to bet set and must be bigger than 0!';
    }

    $route = $_POST['route'];
    if (!$route || in_array($route, $routes, true)) {
        $errors['route'] = 'The route of the trail needs to be set!';
    }

    if (empty($errors)) {
        JungleHunter_Database::junglehunter_insert_trail($name, floatval(str_replace(',', '.', $length)), $route);
        $name = '';
        $length = '';
        $route = '';
    }
}

?>

<div class="wrap">
    <div id="junglehunter-input">
        <h1>Insert Trail:</h1>
        <form action="<?php menu_page_url("junglehunter-trails") ?>" method="post">
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-name">Name:</label>
                <input type="text" id="junglehunter-trail-name" name="name" placeholder="A name for the Trail"
                       value="<?php echo $name ?>">
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-length">Length:</label>
                <input type="text" id="junglehunter-trail-length" name="length"
                       placeholder="The length of the trail in kilometer"
                       value="<?php echo $length ?>"
                       oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(,.*),/g, '$1');">
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-trail-route" class="junglehunter-block">Route:</label>
                <select name="route" id="junglehunter-trail-route">
                    <?php
                    foreach ($routes as $single_route) {
                        $isSelected = $single_route->route_name == $route ? 'selected' : '';
                        echo "<option $isSelected value='$single_route->route_name'>$single_route->route_name</option>";
                    }
                    ?>
                </select>
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
            <th>Id</th>
            <th>Name</th>
            <th>Length in kilometer</th>
            <th>Route</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $trails = JungleHunter_Database::junglehunter_get_trails();
        foreach ($trails as $trail) {
            echo '<tr>';
            echo "<td>$trail->trail_id</td>";
            echo "<td>$trail->trail_name</td>";
            echo '<td>' . str_replace('.', ',', $trail->length) . '</td>';
            echo "<td>$trail->route_name</td>";
            echo '<tr/>';
        }
        ?>
        </tbody>
    </table>
</div>
