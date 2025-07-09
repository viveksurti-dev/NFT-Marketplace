<?php
require_once 'config.php';
require_once 'Navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us - NFT Marketplace</title>
    <!-- Style : main.css | line : 820 -->
    <style>
        .content {
            height: 90vh;
            max-height: 100%;
            overflow: scroll;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .about-head-image {
            overflow: hidden;
            width: 100%;
            height: auto;
        }

        .about-head-image .nft {
            top: -80px;
            left: 100px;
            z-index: 1;
            position: absolute;
            overflow: hidden;
            object-fit: cover;
            max-height: 350px;
            animation: 5s up-down-2 infinite;
        }

        .about-head-image .nft-hand {
            z-index: 0;
            margin-top: 25px;
            overflow: hidden;
            object-fit: cover;
            max-height: 600px;
            animation: 5s half-round infinite;
        }

        @keyframes up-down-2 {
            0% {}

            50% {
                transform: translateY(-70px)rotateZ(7deg);
                filter: drop-shadow(0px 15px 50px black);
                scale: 1.05;

            }

            100% {}
        }

        @keyframes half-round {
            0% {}

            50% {
                transform: rotatez(7deg);
            }

            100% {}
        }

        .portfolio-image {
            width: 100%;
            height: 550px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .portfolio-image img {
            width: fit-content;
            height: 90%;
            overflow: hidden;
            object-fit: contain;
            overflow: hidden;
            border-radius: 5px;
        }

        .team-image {
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 5px;
            position: relative;
        }

        .team-image .team-info {
            bottom: -30%;
            position: absolute;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            transition: all 0.5s ease-in-out;
        }

        .team-image:hover .team-info {
            bottom: 0%;
        }

        .team-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
            transition: all 0.5s ease-in-out;
        }

        .team-image:hover img {
            scale: 1.05;
        }
    </style>
</head>

<body>
    <!-- section 1  -->
    <div class="container-fluid content d-flex flex-wrap about-1 mb-4">
        <div class="col-md-6">
            <div class="d-flex justify-content-center about-head-image">
                <img src="<?php echo BASE_URL ?>Assets/illu/nft.png" class="nft">
                <img src="<?php echo BASE_URL ?>Assets/illu/hand.png" class="nft-hand">
            </div>
        </div>
        <div class="col-md-6 text-left">
            <div class="about-heading">
                <h2>
                    Empowering Creativity in the Digital Sphere
                </h2>
            </div>
            <div class="mt-3">
                Here at Creative Tokens, we're passionate about exploring the limitless possibilities of non-fungible tokens, or NFTs. These digital assets possess unique characteristics: they're one-of-a-kind, verifiably scarce, tradable, and adaptable across various platforms. Just like tangible assets, NFTs grant you complete ownership rights, allowing you to dispose of them, share them with friends worldwide, or trade them on an open marketplace. However, unlike physical assets, they harness the full potential of digital programmability.
            </div>
            <div class="mt-3">
                At the heart of our mission lies the belief that open-source protocols such as Ethereum, coupled with interoperable standards like ERC-721 and ERC-1155, will pave the way for dynamic new economies. We're dedicated to crafting tools that empower consumers to exchange their assets freely, enable creators to unleash innovative digital creations, and provide developers with the means to construct comprehensive, integrated marketplaces for digital goods.
            </div>
            <div class="mt-3">
                We take pride in being pioneers as the premier platform for NFTs in the Indian market.
            </div>

        </div>
    </div>

    <!-- section 2 -->
    <div class="container-fluid d-flex flex-wrap about-2 mt-5 mb-5">
        <div class="col-md-12">
            <h3 class="text-center">Who Is NFT Marketplace</h3>
        </div>
        <div class="text-center col-md-12 mb-2">
            Allow us to introduce ourselves! Hear from our CEO, Devin Finzer, about who we are, how we started, <br />
            and where we're headed.
            <a class="link" href="">Learn more about NFT Marketplace in our Learn Center</a>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
            <iframe width="80%" height="500px" src="https://www.youtube.com/embed/H3TABd_nBJU?si=yM-K98C48t7y7E8B" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>

    <!-- section 3 -->
    <div class="container d-flex flex-wrap about-2 mt-5 mb-5">
        <div class="col-md-12 text-center mb-3">
            <h2>
                Our Story
            </h2>
        </div>
        <div class="col-md-6 ">
            <div class="d-flex flex-wrap portfolio-image">
                <img src="<?php echo BASE_URL ?>Assets\AutherImage\IMG_9350.jpg" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div>
                NFT Marketplace was born out of a shared vision to democratize the world of digital ownership and revolutionize the way people interact with art and collectibles. Our journey began with a group of passionate individuals who recognized the transformative potential of blockchain technology in reshaping the creative landscape.
            </div>
            <div class="mt-3">
                Driven by a desire to empower creators and collectors alike, we set out to create a platform that would not only provide a marketplace for NFTs but also foster a sense of community and innovation within the digital art space.
            </div>
            <div class="mt-3">
                Our founders, drawn from diverse backgrounds in technology, finance, and the arts, came together with a shared belief in the power of decentralized technologies to redefine traditional notions of ownership and authenticity. Inspired by the pioneering spirit of early blockchain adopters, we embarked on a mission to build a platform that would democratize access to digital art while empowering creators to monetize their work transparently and fairly.
            </div>
            <div class="mt-3">
                As we navigated the complex landscape of blockchain development and digital marketplaces, we remained steadfast in our commitment to sustainability and inclusivity.
            </div>
            <div class="text-center mt-3">
                <a href="#team" class="btn btn-outline-warning">
                    Meet Our Team
                </a>
            </div>
        </div>
    </div>

    <!-- section 4 -->
    <div id="team" class="container d-flex flex-wrap about-4 mt-5 mb-2">
        <div class="text-center col-md-12 mb-3">
            <h2>Meet Our Team</h2>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
            <div class="col-md-4">
                <div class="team-image">
                    <img src="<?php echo BASE_URL ?>Assets/AutherImage/vivek-2.jpg" loading="lazy">
                    <div class="team-info p-3">
                        <div>
                            <h5>Vivek Surati</h5>
                            <small class="caption">
                                Founder of our NFT marketplace passionately shapes a decentralized future where creativity meets blockchain.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-image">
                    <img src="<?php echo BASE_URL ?>Assets/AutherImage/dhruv-1.jpg" style="object-fit: cover;" loading="lazy">
                    <div class="team-info p-3">
                        <div>
                            <h5>Dhruv Modi</h5>
                            <small class="caption">
                                The Co-Founder of our NFT marketplace ardently molds a decentralized horizon where the realms of creativity converge with blockchain technology.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center col-md-12 mt-3">
            <a href="#joinUs" class="btn btn-primary">
                Join With Us
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <hr class="mt-3 mb-3" />
    </div>
    <!-- section 5 -->
    <div class="container d-flex flex-wrap about-5 mb-5">
        <div class="text-center col-md-12 mb-3">
            <h2>Security Reports</h2>
        </div>
        <div class="text-left col-md-12 mt-3">
            At NFT Marketplace, we take the security and integrity of our platform very seriously. We regularly conduct comprehensive security assessments and audits to ensure that our marketplace remains a safe and trusted environment for creators and collectors alike.
            <div class="mt-3">
                Our team collaborates with leading cybersecurity experts and blockchain specialists to identify and address any potential vulnerabilities proactively. Through diligent monitoring and continuous improvement, we strive to maintain the highest standards of security to protect the assets and data of our users.
            </div>
            <div class="mt-3">
                We are committed to transparency and accountability in all aspects of our operations, including security. Therefore, we make our security reports readily available to our community, providing insights into our security practices, findings from audits, and steps taken to enhance the resilience of our platform.
            </div>
            <div class="mt-3">

                By prioritizing security and embracing best practices, we aim to instill confidence and trust in our platform, ensuring that our users can engage with NFTs with peace of mind. Together, we are building a secure and resilient ecosystem that empowers creators and collectors to thrive in the digital age.
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <hr class="mt-3 mb-3" />
    </div>

    <!-- section 6 -->
    <div id="joinUs" class="container d-flex flex-wrap about-5 mb-2 mt-5 mb-5">
        <div class="text-center col-md-12 mb-3">
            <h2>Join Us</h2>
        </div>
        <div class="col-md-6 mt-2">
            <div class="d-flex flex-wrap team-image ">
                <img src="<?php echo BASE_URL ?>Assets/illu/NFT-Join.png" alt="">
            </div>
        </div>
        <div class="col-md-6">
            <div>
                Join us today and become part of a vibrant community at NFT Marketplace! Whether you're an artist seeking to showcase your work, a collector searching for unique treasures, or simply curious about the world of NFTs, there's a place for you here. Experience the power of decentralized creativity and join us in shaping the future of digital ownership. Together, let's explore new possibilities and unlock the potential of blockchain technology. Join us on NFT Marketplace Name and be part of something extraordinary.
            </div>
            <div class="mt-3">
                <?php
                if (isset($_POST['join-us']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                    $joinname = $_POST['join-name'];
                    $joinemail = $_POST['join-email'];
                    $jointext = $_POST['join-text'];

                    if (isset($_POST['join-us'])) {

                        $mail->setFrom($joinemail, $joinname);
                        $mail->addReplyTo($joinemail, $joinname);
                        require_once('mailpage/joinus.php');

                        if ($mail->send()) {
                            $_SESSION['create'] = "Your Mail Sent Successfully!";
                            echo '<script> window.location.href = "";</script>';
                            exit();
                        } else {
                            $_SESSION['create'] = "There was an error sending your email. Please try again later.";
                            echo '<script> window.location.href = "";</script>';
                            exit();
                        }
                    }
                }
                ?>
                <form method="post">
                    <div class="d-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <input type="text" name="join-name" class="input form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="join-email" class="input form-control" placeholder="Your Mail" required>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea name="join-text" cols="30" rows="3" class="form-control input" placeholder="Your Query" required></textarea>
                    </div>
                    <div class="text-center mt-3">
                        <button name="join-us" class="btn btn-outline-warning">
                            Inquire Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <iframe src="https://www.chatbase.co/chatbot-iframe/ki48OV3KD2E4o0fjV03Kd" title="ArtBoat" width="0" style="height: 0; min-height: 0" frameborder="0"></iframe>

    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "ki48OV3KD2E4o0fjV03Kd",
            domain: "www.chatbase.co"
        }
    </script>
    <script src="https://www.chatbase.co/embed.min.js" chatbotId="ki48OV3KD2E4o0fjV03Kd" domain="www.chatbase.co" defer>
    </script>
</body>

</html>

<?php require_once './footer.php' ?>
<?php
// Display error message if it exists
if (isset($_SESSION['create'])) {
    echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='Assets/illu/web-logo.png' alt='Brand Image'/>
                            </div>
                            <div class='header-name'>NFT Marketplace</div>
                        </div>
                        <div class='time'>
                            Just Now
                        </div>
                    </div>
                    <div class='cust_alert-body'>
                    {$_SESSION['create']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['create']);
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertContainer = document.getElementById('cust_alertContainer');

        setTimeout(function() {
            alertContainer.style.right = '20px';

            setTimeout(function() {
                alertContainer.style.right = '-400px';
            }, 5000);
        }, 50);
    });
</script>