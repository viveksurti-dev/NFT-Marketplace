<style>
    .dashboard-menus {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: scroll;
        top: 65px;
        padding: 10px;
        z-index: 1;
        background-color: #131313;
    }

    .dash-menu {
        color: gainsboro;
        padding: 10px;
        transition: 0.3s ease-in-out;
    }

    .dashboard-menus .active {
        background-color: #252525 !important;
        border: none !important;
        border-bottom: 1px solid !important;
    }

    .dash-menu:hover {
        background-color: #181818;

    }
</style>

<div class="dashboard-menus mt-5 sticky-top">
    <Button id="dashm1" class="btn dash-menu me-2 active" onclick="showContent('dashc1', 'dashm1')">Collected</Button>
    <Button id="dashm3" class="btn dash-menu me-2" onclick="showContent('dashc3', 'dashm3')">Deals</Button>
    <Button id="dashm4" class="btn dash-menu me-2" onclick="showContent('dashc4', 'dashm4')">Your Creation</Button>
    <Button id="dashm5" class="btn dash-menu me-2" onclick="showContent('dashc5', 'dashm5')">Favorites</Button>

</div>

<hr style="background: gray;" class="mt-2 mb-2 m-2" />

<div class="container-fluid mt-2">

    <div id="dashc1" class="dashc1 content">
        <?php require_once 'collected.php' ?>
    </div>
    <div id="dashc3" class="dashc3 content hidden">
        <?php require_once 'deals.php' ?>

    </div>
    <div id="dashc4" class="dashc4 content hidden">
        <?php require_once 'creation.php' ?>
    </div>
    <div id="dashc5" class="dashc5 content hidden">
        <?php require_once 'favorites.php'; ?>
    </div>
</div>
<script>
    function showContent(contentId, buttonId) {
        // Hide all content 
        var contentDivs = document.getElementsByClassName('content');
        for (var i = 0; i < contentDivs.length; i++) {
            contentDivs[i].classList.add('hidden');
        }

        // Deactivate all buttons
        var buttonElements = document.getElementsByTagName('button');
        for (var i = 0; i < buttonElements.length; i++) {
            buttonElements[i].classList.remove('active');
        }

        document.getElementById(contentId).classList.remove('hidden');
        document.getElementById(buttonId).classList.add('active');

        localStorage.setItem('activeButtonId', buttonId);
    }

    document.addEventListener("DOMContentLoaded", function() {
        var activeButtonId = localStorage.getItem('activeButtonId');

        if (activeButtonId) {
            document.getElementById(activeButtonId).click();
        } else {
       
        }
    });
</script>