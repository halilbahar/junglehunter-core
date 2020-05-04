<?php
function validateBody($isCreating, &$name, &$length, &$route, $routes) {
    $errors = array();

    if (!isset($_POST['name']) || (strlen(trim($_POST['name'])) == 0)) {
        $errors['name'] = 'The name of the Trail cannot be empty!';
    } else if (strlen(trim($_POST['name'])) > 100) {
        $errors['name'] = 'The name of the trail is too long!';
    }
//    else if ($isCreating && JungleHunter_Database::junglehunter_get_route_by_name(trim($_POST['name'])) != NULL) {
//        $errors['name'] = 'This name already exists!';
//    }
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }

    if (!isset($_POST['length']) || (strlen(trim($_POST['length'])) == 0)) {
        $errors['length'] = 'The length of the trail cannot be empty!';
    } else if (!is_numeric(str_replace(',', '.', $length))) {
        $errors['length'] = 'The length of the trail needs to be a number!';
    }
    if (isset($_POST['length'])) {
        $length = trim($_POST['length']);
    }

    if (!isset($_POST['route'])) {
        $errors['route'] = 'The route of the trail needs to be set!';
    } else if (in_array($route, $routes, true)) {
        $errors['route'] = 'This route does not exist!';
    }
    if (isset($_POST['route'])) {
        $route = trim($_POST['route']);
    }

    return $errors;
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
        <form action="<?php menu_page_url("junglehunter-trails") ?>" method="post" id="junglehunter-form">
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
                <label for="junglehunter-trail-route">Route:</label>
                <select name="route" id="junglehunter-trail-route">
                    <?php
                    $hasSelected = false;
                    foreach ($routes as $single_route) {
                        $isSelected = '';
                        if ($single_route->route_name == $route) {
                            $isSelected = 'selected';
                            $hasSelected = true;
                        }
                        echo "<option $isSelected value='$single_route->route_name'>$single_route->route_name</option>";
                    }
                    ?>
                    <option value="" <?php echo($hasSelected ? '' : 'selected') ?> disabled hidden>
                        The Route that the Trail belongs to
                    </option>
                </select>
            </div>
            <input type="submit" value="Create">
            <input type="button" value="Save">
            <input type="button" value="Delete">
            <input type="button" value="Cancel" id="junglehunter-route-cancel">
            <input type="hidden" value="POST" id="junglehunter-method" name="_method">
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
