<?php
$id = $name = $comment = $note = $latitude = $longitude = $trail_id = $response = '';

function validateBody(&$name, &$comment, &$note, &$latitude, &$longitude, &$trail_id, $trails) {
    $errors = array();

    // Validate route if it is: empty, exists
    if (!isset($_POST['trail_id'])) {
        $errors['trail_id'] = 'The trail of the Control Points needs to be set!';
    }

    // Validate name if it is: empty, too long, already existing
    if (!isset($_POST['name']) || (strlen(trim($_POST['name'])) == 0)) {
        $errors['name'] = 'The name of the Control Point cannot be empty!';
    } else if (strlen(trim($_POST['name'])) > 50) {
        $errors['name'] = 'The name of the Control Point is too long!';
    } else {
        $row = JungleHunter_Database::junglehunter_get_control_point_by_name(trim($_POST['name']));
        if ($row != NULL) {
            if (!isset($_POST['trail_id'])) {
                $errors['name'] = 'Please select a trail to see if the name is available!';
            } else if ($row->trail_id == $_POST['trail_id'] && isset($_POST['id']) && $_POST['id'] != $row->control_point_id) {
                $errors['name'] = 'This name already exists!';
            }
        }
    }

    // Validate comment if it is: empty, too long
    if (!isset($_POST['comment']) || (strlen(trim($_POST['comment'])) == 0)) {
        $errors['comment'] = 'The comment of the Control Point cannot be empty!';
    } else if (strlen($_POST['comment']) > 255) {
        $errors['comment'] = 'The comment of the Control Point is too long!';
    }

    // Validate note if it is: empty, too long
    if (!isset($_POST['note']) || (strlen(trim($_POST['note'])) == 0)) {
        $errors['note'] = 'The note of the Control Point cannot be empty!';
    } else if (strlen($_POST['note']) > 255) {
        $errors['note'] = 'The note of the Control Point is too long!';
    }

    // Validate latitude if it is: empty, a number
    if (!isset($_POST['latitude']) || (strlen(trim($_POST['latitude'])) == 0)) {
        $errors['latitude'] = 'The latitude of the Control Point cannot be empty!';
    } else if (!is_numeric(str_replace(',', '.', $_POST['latitude']))) {
        $errors['latitude'] = 'The latitude of the Control Point needs to be a number!';
    }

    // Validate latitude if it is: empty, a number
    if (!isset($_POST['longitude']) || (strlen(trim($_POST['longitude'])) == 0)) {
        $errors['longitude'] = 'The longitude of the Control Point cannot be empty!';
    } else if (!is_numeric(str_replace(',', '.', $_POST['longitude']))) {
        $errors['longitude'] = 'The longitude of the Control Point needs to be a number!';
    }

    if (isset($_POST['trail_id'])) {
        $trail_id = trim($_POST['trail_id']);
    }
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }
    if (isset($_POST['comment'])) {
        $comment = trim($_POST['comment']);
    }
    if (isset($_POST['note'])) {
        $note = trim($_POST['note']);
    }
    if (isset($_POST['latitude'])) {
        $latitude = trim($_POST['latitude']);
    }
    if (isset($_POST['longitude'])) {
        $longitude = trim($_POST['longitude']);
    }

    return $errors;
}

$id = $name = $comment = $note = $trail_id = $latitude = $longitude = $response = '';
$trails = JungleHunter_Database::junglehunter_get_trails();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method'])) {
    if ($_POST['_method'] == 'POST') {
        $errors = validateBody($name, $comment, $note, $latitude, $longitude, $trail_id, $trails);
        if (empty($errors)) {
            JungleHunter_Database::junglehunter_insert_control_point(
                $name,
                $comment,
                $note,
                str_replace(',', '.', $latitude),
                str_replace(',', '.', $longitude),
                $trail_id
            );
            $response = 'A new Control Point was created!';
            $name = $comment = $note = $latitude = $longitude = $trail_id = '';
        }
    } else if ($_POST['_method'] == 'DELETE' && isset($_POST['id'])) {
        $response = JungleHunter_Database::junglehunter_delete_control_point(
            $_POST['id']
        ) ? 'The Control Point was deleted!' : 'This Control Point does not exist!';
    } else if ($_POST['_method'] == 'PUT' && isset($_POST['id'])) {
        $errors = validateBody($name, $comment, $note, $latitude, $longitude, $trail_id, $trails);
        $id = $_POST['id'];
        if (empty($errors)) {
            $response = JungleHunter_Database::junglehunter_update_control_point(
                $id,
                $name,
                $comment,
                $note,
                str_replace(',', '.', $latitude),
                str_replace(',', '.', $longitude),
                $trail_id
            ) ? 'The Trail was updated!' : 'Nothing was changed!';
            $id = $name = $comment = $note = $latitude = $longitude = $trail_id = '';
        }
    }
}
?>

<div class="wrap">
    <?php if (isset($response) && $response != '')
        echo "<div id='junglehunter-status-bar'>$response</div>" ?>
    <div id="junglehunter-input">
        <h1>Create new Route:</h1>
        <form action="<?php menu_page_url("junglehunter-control-points") ?>" method="post" id="junglehunter-form">
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-trail">Trail:</label>
                <select name="trail_id" id="junglehunter-control-point-trail"
                        class="<?php if (isset($errors['trail_id']))
                            echo 'junglehunter-red-border' ?>">
                    <?php
                    $has_selected = false;
                    var_dump($trail_id);
                    var_dump($trails);
                    foreach ($trails as $single_trail) {
                        $is_selected = '';
                        if ($single_trail->trail_id == $trail_id) {
                            $is_selected = 'selected';
                            $has_selected = true;
                        }
                        echo "<option $is_selected value='$single_trail->trail_id'>$single_trail->route_name - $single_trail->trail_name</option>";
                    }
                    ?>
                    <option value="" <?php echo($has_selected ? '' : 'selected') ?> disabled hidden>
                        The Trail that the Control Point belongs to
                    </option>
                </select>
                <span class="junglehunter-error-message"><?php if (isset($errors['trail_id']))
                        echo $errors['trail_id'] ?>
                </span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-name">Name:</label>
                <input id="junglehunter-control-point-name"
                       placeholder="A name for the Control Point"
                       type="text"
                       name="name"
                       value="<?php echo $name ?>"
                       class="<?php if (isset($errors['name']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message">
                    <?php if (isset($errors['name']))
                        echo $errors['name'] ?>
                </span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-comment">Comment:</label>
                <input id="junglehunter-control-point-comment"
                       placeholder="The comment of the Control Point"
                       type="text"
                       name="comment"
                       value="<?php echo $comment ?>"
                       class="<?php if (isset($errors['comment']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message">
                    <?php if (isset($errors['comment']))
                        echo $errors['comment'] ?>
                </span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-note">Note:</label>
                <input id="junglehunter-control-point-note"
                       placeholder="The note of the Control Point"
                       type="text"
                       name="note"
                       value="<?php echo $note ?>"
                       class="<?php if (isset($errors['note']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message">
                    <?php if (isset($errors['note']))
                        echo $errors['note'] ?>
                </span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-latitude">Latitude:</label>
                <input id="junglehunter-control-point-latitude"
                       placeholder="The latitude of the Control Point"
                       type="text"
                       name="latitude"
                       value="<?php echo $latitude ?>"
                       class="<?php if (isset($errors['latitude']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message">
                    <?php if (isset($errors['latitude']))
                        echo $errors['latitude'] ?>
                </span>
            </div>
            <div class="junglehunter-input-row">
                <label for="junglehunter-control-point-longitude">Longitude:</label>
                <input id="junglehunter-control-point-longitude"
                       placeholder="The longitude of the Control Point"
                       type="text"
                       name="longitude"
                       value="<?php echo $longitude ?>"
                       class="<?php if (isset($errors['longitude']))
                           echo 'junglehunter-red-border' ?>">
                <span class="junglehunter-error-message">
                    <?php if (isset($errors['longitude']))
                        echo $errors['longitude'] ?>
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
            <input type="hidden" value="POST" id="junglehunter-method" name="_method" class="junglehunter-button">
        </form>
    </div>
    <h1>All Routes:</h1>
    <table id="junglehunter-table" class="junglehunter-unselectable">
        <thead>
        <tr>
            <th>Control Point Name</th>
            <th>Comment</th>
            <th>Note</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Trail</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $control_points = JungleHunter_Database::junglehunter_get_control_points();
        foreach ($control_points as $control_point) {
            $selected_class = $control_point->control_point_id == $id ? 'junglehunter-selected-table' : '';
            echo "<tr class='junglehunter-control-point-tr $selected_class'>";
            echo "<td data-id='$control_point->control_point_id'>$control_point->control_point_name</td>";
            echo "<td>$control_point->comment</td>";
            echo "<td>$control_point->note</td>";
            echo "<td>$control_point->latitude</td>";
            echo "<td>$control_point->longitude</td>";
            echo "<td data-id='$control_point->trail_id'>$control_point->trail_name</td>";
            echo '<tr/>';
        }
        ?>
        </tbody>
    </table>
</div>
