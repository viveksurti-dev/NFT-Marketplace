<?php

if ($USER['strikes'] >= 1) {
    $strikes = $USER['strikes'];
} else {
    $strikes = "0";
}


?>


<div>
    <div class="container mt-3 d-flex flex-wrap justify-content-center">
        <div class="col-md-5">
            <div class="card" style="height: 100%;">
                <div>
                    <i class="bi bi-exclamation-diamond loss-price me-3"></i><?php echo $strikes ?> of 3 Community Guidelince strikes
                </div>
                <small class="caption mt-3">
                    <?php if ($strikes == '0') {
                        echo
                        '<li>
                        The absence of clear guidelines can be both daunting and liberating. Participants must tread carefully, ensuring due diligence in their transactions amidst the landscape of innovation. However, this lack of rigidity also fosters an environment ripe for experimentation and creativity.
                        </li>
                        <li class="mt-2">
                        Artists are free to explore novel forms of expression, while collectors can engage with a diverse array of digital assets. Yet, there remains a pressing need for industry stakeholders to collaboratively establish standards ensuring transparency, security, and ethical practices.
                        </li>';
                    } else if ($strikes >= '0') { ?>
                        <ul>
                            <li>
                                Unfortunately, your account has been restricted due to a violation of our
                                <a href="<?php echo BASE_URL ?>Terms.php" class="link">Community Guidelines</a>.
                                We kindly ask you to review and adhere to our guidelines to ensure a positive experience for all members of our community.
                            </li>
                            <li class="mt-2">
                                We understand that you wish to engage in various activities such as creating NFTs, buying, selling, bidding, auctioning, and offering. Rest assured, once your account compliance is reinstated for
                                <?php
                                if ($strikes === '1') {
                                    echo '3 Days';
                                } else if ($strikes === '2') {
                                    echo '7 Days';
                                } else if ($strikes === '3') {
                                    echo '14 Days';
                                }
                                ?>
                            </li>
                        </ul>
                    <?php } ?>
                </small>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card" style="height: 100%;">
                If this happen again
                <small class="caption mt-3">
                    <ul>
                        <li>
                            Please be aware that receiving another Community Guidelines Strike will result in further consequences for your account, including potential suspension or termination.
                        </li>
                        <li class="mt-3">
                            We understand your desire to engage in various activities such as creating NFTs, buying, selling, bidding, auctioning, and offering. Once the suspension period of
                            <strong>
                                <?php
                                if ($strikes == 0) {
                                    echo '3 Days';
                                } elseif ($strikes == 1) {
                                    echo '7 Days';
                                } else if ($strikes == 2) {
                                    echo '14 Days';
                                } else {
                                }
                                ?>
                            </strong> is over, you'll be able to resume these activities.
                        </li>
                    </ul>
                </small>
            </div>
        </div>
    </div>
    <!-- status container -->
    <div class="container mt-3 d-flex flex-wrap justify-content-center ">
        <div class="col-md-10">
            <div class="card">
                <div class=" text-center col-md-12">
                    <span class="me-2"> Status :</span>
                    <span class="caption">

                        <?php
                        if ($strikes === '1') {
                            echo '1 Strike - Initial Check-up';
                        } else if ($strikes === '2') {
                            echo '2nd Strike - Follow-up Examination';
                        } else if ($strikes === '3') {
                            echo '3rd Strike - Critical Diagnosis';
                        } else {
                            echo 'Healthy';
                        }
                        ?>
                    </span>
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    <table class="w-100  col-md-8">
                        <tbody>
                            <tr class="d-flex justify-content-around">
                                <td class=" text-center
                                <?php if ($strikes >= 1) {
                                    echo 'text-danger';
                                } else {
                                    echo 'text-success';
                                } ?>">
                                    <h1>
                                        <i class="bi bi-emoji-smile"></i>
                                    </h1>
                                    <small> Flabbergasted</small>
                                </td>

                                <td class="d-flex align-items-center
                                <?php if ($strikes >= 2) {
                                    echo 'text-danger';
                                } else {
                                    echo 'text-success';
                                } ?>">
                                    <h6>
                                        <i class="bi bi-arrow-right"></i>
                                    </h6>
                                </td>
                                <td class="text-center <?php if ($strikes >= 2) {
                                                            echo 'text-danger';
                                                        } else {
                                                            echo 'text-success';
                                                        } ?>">
                                    <h1>
                                        <i class="bi bi-emoji-neutral"></i>
                                    </h1>
                                    <small>Bumfuzzle</small>
                                </td>
                                <td class="d-flex align-items-center  <?php if ($strikes >= 3) {
                                                                            echo 'text-danger';
                                                                        } else {
                                                                            echo 'text-success';
                                                                        } ?>">
                                    <h6>
                                        <i class="bi bi-arrow-right"></i>
                                    </h6>
                                </td>
                                <td class="text-center  <?php if ($strikes >= 3) {
                                                            echo 'text-danger';
                                                        } else {
                                                            echo 'text-success';
                                                        } ?>">
                                    <h1>
                                        <i class="bi bi-emoji-tear"></i>
                                    </h1>
                                    <small>Gobbledygook</small>
                                </td>
                                <td class="d-flex align-items-center  <?php if ($strikes >= 4) {
                                                                            echo 'text-danger';
                                                                        } else {
                                                                            echo 'text-success';
                                                                        } ?>">
                                    <h6>
                                        <i class="bi bi-arrow-right"></i>
                                    </h6>
                                </td>
                                <td class="text-center <?php if ($strikes >= 4) {
                                                            echo 'text-danger';
                                                        } else {
                                                            echo 'text-success';
                                                        } ?>">
                                    <h1>
                                        <i class="bi bi-emoji-frown"></i>
                                    </h1>
                                    <small>Widdershins</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- instruction container -->
    <div class="container mt-3 d-flex flex-wrap justify-content-center mb-3">
        <div class="col-md-10">
            <small class="card">
                <h4>Empowering Activism</h4>
                <div class="mt-2">
                    <strong> Verification and Authentication :</strong> <span class="caption">Implement a robust verification process for both creators and buyers to ensure the legitimacy of NFTs listed on the marketplace. This can involve verifying the identity of creators and conducting due diligence on their work.</span>
                </div>

                <div class="mt-2">
                    <strong>Smart Contract Security:</strong> <span class="caption">Ensure that smart contracts governing the creation, sale, and transfer of NFTs are thoroughly audited for security vulnerabilities. Smart contracts should be designed to prevent unauthorized access, tampering, or exploitation.</span>
                </div>

                <div class="mt-2">
                    <strong>Transparency and Disclosure:</strong> <span class="caption">Provide clear and comprehensive information about each NFT, including its creator, provenance, ownership history, and any associated rights or restrictions. Transparency builds trust and helps users make informed decisions.</span>
                </div>
                <div class="mt-2">
                    <strong>Intellectual Property Rights Protection:</strong> <span class="caption">Enforce strict policies to prevent the listing of NFTs that infringe upon intellectual property rights. Implement procedures for handling copyright claims and removing infringing content promptly.</span>
                </div>
                <div class="mt-2">
                    <strong>Secure Transactions:</strong> <span class="caption">Utilize secure payment gateways and encryption protocols to safeguard financial transactions conducted on the marketplace. Provide options for multiple payment methods and ensure that sensitive information is protected.</span>
                </div>
                <div class="mt-2">
                    <strong>User Privacy:</strong> <span class="caption">Prioritize the privacy of users' personal information and transaction data. Implement data protection measures in compliance with relevant privacy regulations, such as GDPR or CCPA.</span>
                </div>
                <div class="mt-2">
                    <strong>Community Guidelines:</strong> <span class="caption">Establish community guidelines that outline acceptable behavior and content on the platform. Prohibit activities such as harassment, fraud, or dissemination of harmful content. Enforce these guidelines consistently and fairly.</span>
                </div>
                <div class="mt-2">
                    <strong>Education and Awareness:</strong> <span class="caption">Educate users about the risks associated with NFTs, such as the potential for scams, counterfeit items, or price volatility. Provide resources and guidance on how to conduct due diligence before making a purchase or listing an NFT for sale.</span>
                </div>

                <div class="mt-2">
                    <strong>Customer Support and Dispute Resolution:</strong> <span class="caption">Offer responsive customer support services to address user inquiries, resolve disputes, and handle complaints effectively. Establish transparent procedures for dispute resolution and mediation.</span>
                </div>
                <div class="mt-2">
                    <strong>Regular Audits and Updates:</strong> <span class="caption">Conduct regular security audits of the marketplace platform to identify and address any vulnerabilities or weaknesses. Stay informed about emerging threats and security best practices, and update systems accordingly.</span>
                </div>
            </small>
        </div>
    </div>
</div>