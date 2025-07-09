<?php
// session_start();
require_once("Navbar.php");
include 'config.php';
$query = "SELECT * FROM faqs";
$result = mysqli_query($conn, $query);

// Check for errors in the query
// if (!$result) {
//     die("Query failed: " . mysqli_error($conn));
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - FAQs</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">




</head>

<body>
    <div class="faq-head">
        <h3>We Are Here To Help</h3>
        <p class="mt-2 text-center">“There is no exercise better for the heart than reaching down and lifting people up.”</p>
        <input type="text" class="mt-3 input form-control faq-search" placeholder="Enter Your Queries">
    </div>

    <div class="faq-body container">
        <div class="faq-search-results d-flex flex-wrap justify-content-center">
            <h3 class="search-query"></h3>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Function to handle search input
            $(".faq-search").on("input", function() {
                var searchQuery = $(this).val().trim().toLowerCase();
                filterFaqs(searchQuery);
            });

            function filterFaqs(query) {
                $(".faq-card").hide(); // Hide all FAQ cards initially

                $(".faq-card").each(function() {
                    var faqTitle = $(this).find(".card-title").text().toLowerCase();
                    var faqDescription = $(this).find(".card-description").text().toLowerCase();
                    var faqId = $(this).find(".read-more").attr("onclick").match(/\d+/)[0];

                    if (faqTitle.includes(query) || faqDescription.includes(query)) {
                        // Show the FAQ card
                        $(this).show();
                    }
                });

                // Display search results in a separate div
                var searchResults = $(".faq-search-results");
                searchResults.empty();

                $(".faq-card:visible").each(function() {
                    $(this).clone().appendTo(searchResults);
                });

                // Update the search query in the h3 element
                $(".search-query").text(query !== "" ? "Search Results for: '" + query + "'" : "");
            }
        });
    </script>

    <div class="faq-body container">
        <?php if (!$result) {
            echo 'FAQs Not Available';
        } else { ?>
            <?php
            // Loop through each FAQ and display it in a card
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="faq-card">
                    <div class="card-image">
                        <img src="Assets/FAQs/<?php echo $row['faqimage']; ?>" alt="">
                    </div>
                    <div class="card-detail">
                        <div class="card-title">
                            <?php echo $row['faqtitle']; ?>
                        </div>
                        <div class="card-description caption">
                            <?php echo $row['faqdescription']; ?>
                        </div>
                        <div class="card-link">
                            <button class="btn read-more" onclick="openfaq(<?php echo $row['faqid']; ?>)">Read More</button>
                        </div>
                    </div>
                </div>
                <div id="faq_<?php echo $row['faqid']; ?>" class="modal">
                    <div class="modal-content col-md-12">
                        <span class="close" onclick="closefaq(<?php echo $row['faqid']; ?>)">&times;</span>
                        <div class="faq-modal-info">
                            <div class="faq-modal-image col-md-5">
                                <img src="Assets/FAQs/<?php echo $row['faqimage']; ?>">
                            </div>
                            <div class="faq-modal-details col-md-7">
                                <div class="faq-modal-detail">
                                    <h2><?php echo $row['faqtitle']; ?> <span class="faq-modal-description caption"><?php echo $row['created_date']; ?> | <?php echo $row['created_time']; ?></span></h2>
                                    <p class="faq-modal-description mt-1 caption"><?php echo $row['faqdescription']; ?></p>
                                </div>
                                <div class="faqs-edit-btn d-flex justify-content-center">
                                    <?php if ($userrole == 'admin') { ?>
                                        <!-- Edit form -->
                                        <a href="Functions/editFAQ.php?faqid=<?php echo $row['faqid']; ?>" class="btn edit me-2">Edit</a>
                                        <a href="Functions/deleteFAQ.php?faqid=<?php echo $row['faqid']; ?>" onclick="return confirm('Are you sure you want to delete this FAQ? - <?php echo $row['faqtitle']; ?>');" class="btn delete ms-2">Delete</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        <?php
        }
        ?>

        <script>
            function openfaq(faqid) {
                document.getElementById("faq_" + faqid).style.display = "block";
                document.body.classList.add('modal-open');
            }

            function closefaq(faqid) {
                document.getElementById("faq_" + faqid).style.display = "none";
                document.body.classList.remove('modal-open');
            }
        </script>
    </div>

</body>
<?php
include("footer.php"); ?>

</html>