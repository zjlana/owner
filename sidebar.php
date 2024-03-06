<?php
function inflateMenu($ui_name, $path_name, $icon_class)
{
    $selected = '';
    if(!isset($_GET['page'])) {
        header('Location: ./menu.php?page=guestlist');
        return;
    } else {
        $selected = $_GET['page'] == $path_name ? 'bg-success text-white' : '';
    };

    echo '<li class="mb-1">';
    echo '<a class="btn hover-bg rounded ' . $selected . '" href="./menu.php?page=' . $path_name . '" role="button">';
    echo '  <span class="bx ' . $icon_class . ' icon fs-4"></span>';
    echo '  ' . $ui_name;
    echo '</a>';
    echo '</li>';
}

function startDropdownMenu($ui_name, $path_name, $icon_class)
{
    $selected = $_GET['page'] == $path_name ? 'bg-success text-white' : '';
    $selectedCollapse = $_GET['page'] == $path_name ? 'collapsed' : '';
    $selectedCollapseShow = $_GET['page'] == $path_name ? 'collapse show' : 'collapse';

    echo '<li class="mb-1">';
    echo '<button class="btn hover-bg rounded ' . $selected . ' ' . $selectedCollapse . '" data-bs-toggle="collapse" data-bs-target="#' . $path_name . '-collapse" aria-expanded="false">';
    echo '   <span class="bx ' . $icon_class . ' icon fs-4"></span>';
    echo '   ' . $ui_name;
    echo '</button>';
    echo '<div class="custom-style '. $selectedCollapseShow .'" id="' . $path_name . '-collapse">';
    echo '   <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">';
}

function addMenu($ui_name, $id, $target_page) {
    $selected = '';
    if(!isset($_GET['type'])) {
        $selected = 'link-dark';
    } else {
        $selected = $_GET['type'] == $id ? 'link-success' : 'link-dark';
    }
    echo '<li><a href="./menu.php?page=' . $target_page .'&type='. $id .'" class="'. $selected .' rounded">' . $ui_name . '</a></li>';
}

function generateSeparator()
{
    echo '<li class="border-top my-3"></li>';
}

function endDropdownMenu() {
  echo '</ul></div></li>';
}

?>

<div class="sidebar-container">
    <div class="custom-sidebar d-flex bd-highlight">


        <div class="flex-shrink-0 p-3 bg-white" style="width: 280px;">

            <!-- ICON -->
            <div class="image-text d-flex gap-2">
                <span class="image">
                    <img src="img/logokapistahan.jpg" alt="logo">
                </span>
                <div class="text header-text">
                    <span class="name">Kapistahan Lodge and Suites</span>
                    <br>
                    <span class="profesion">Admin</span>
                </div>
            </div>

            <!-- SEARCH -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bx bx-search icon" id="basic-addon1"></span>
                </div>
                <input type="text" class="form-control" placeholder="Search" aria-label="search" aria-describedby="basic-addon1">
            </div>

            <!-- BORDER -->
            <ul class="list-unstyled ps-0 button-container">
                <li class="border-top mb-1"></li>
            </ul>

            <!-- ITEMS -->
            <ul class="list-unstyled ps-0 button-container">
                <?php
                inflateMenu('Guest List', 'guestlist', 'bx-group');
                
                startDropdownMenu('Bookings', 'bookings', 'bx-building');
                addMenu('Short Time', 'shortTime', 'bookings');
                addMenu('Overnight', 'overnight', 'bookings');
                addMenu('Daily', 'daily', 'bookings');
                endDropdownMenu();
               
                startDropdownMenu('Additionals', 'additionals', 'bx-purchase-tag-alt');
                addMenu('Add-ons', 'mainAddons', 'additionals');
                addMenu('Guest Add-ons', 'guestAddons', 'additionals');
                endDropdownMenu();

                inflateMenu('Sales', 'sales', 'bx-money');
                generateSeparator();
                inflateMenu('Settings', 'settings', 'bx-cog');
                ?>

            </ul>
        </div>
    </div>

    <div class="display-logout">
        <ul class="list-unstyled ps-0 button-container">
            <li class="mb-1 d-flex align-items-end">
                <a class="btn hover-bg-danger rounded" href="process.php?action=logout" role="button">
                    <span class="bx bx-log-out icon fs-4"></span>
                    Log-out
                </a>
            </li>
        </ul>
    </div>
</div>
