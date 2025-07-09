-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 12:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nftfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `collectionid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `activityicon` varchar(255) DEFAULT NULL,
  `activityitem` varchar(255) DEFAULT NULL,
  `activtyquantity` int(11) NOT NULL,
  `activityfrom` varchar(255) DEFAULT NULL,
  `activityto` varchar(255) DEFAULT NULL,
  `activity_date` date NOT NULL,
  `activity_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityid`, `userid`, `collectionid`, `nftid`, `activityicon`, `activityitem`, `activtyquantity`, `activityfrom`, `activityto`, `activity_date`, `activity_time`) VALUES
(1, 1, 1, 0, 'createcollection', '1', 0, '1', '-', '2024-03-24', '11:39:00'),
(2, 1, 1, 1, 'createnft', '-', 1, '1', '-', '2024-03-24', '11:41:00'),
(3, 1, 1, 2, 'createnft', '-', 1, '1', '-', '2024-03-24', '11:44:00'),
(4, 1, 1, 3, 'createnft', '-', 1, '1', '-', '2024-03-24', '11:46:00'),
(5, 2, 2, 0, 'createcollection', '2', 0, '2', '-', '2024-03-24', '12:33:00'),
(6, 2, 2, 4, 'createnft', '-', 1, '2', '-', '2024-03-24', '12:34:00'),
(7, 2, 2, 5, 'createnft', '-', 1, '2', '-', '2024-03-24', '12:36:00'),
(8, 2, 2, 6, 'createnft', '-', 1, '2', '-', '2024-03-24', '12:38:00'),
(9, 1, 3, 0, 'createcollection', '3', 0, '1', '-', '2024-03-24', '13:08:00'),
(10, 1, 3, 7, 'createnft', '-', 1, '1', '-', '2024-03-24', '13:09:00'),
(11, 1, 3, 8, 'createnft', '-', 1, '1', '-', '2024-03-24', '13:20:00'),
(12, 1, 4, 0, 'createcollection', '4', 0, '1', '-', '2024-03-24', '13:31:00'),
(13, 2, 5, 0, 'createcollection', '5', 0, '2', '-', '2024-03-24', '13:43:00'),
(14, 2, 5, 13, 'createnft', '-', 1, '2', '-', '2024-03-24', '13:48:00'),
(15, 1, 6, 0, 'createcollection', '6', 0, '1', '-', '2024-03-24', '13:51:00'),
(16, 1, 6, 14, 'createnft', '-', 1, '1', '-', '2024-03-24', '13:52:00'),
(17, 1, 6, 15, 'createnft', '-', 1, '1', '-', '2024-03-24', '13:58:00'),
(18, 3, 7, 0, 'createcollection', '7', 0, '3', '-', '2024-03-24', '14:42:00'),
(19, 3, 7, 16, 'createnft', '-', 1, '3', '-', '2024-03-24', '14:45:00'),
(20, 3, 7, 17, 'createnft', '-', 1, '3', '-', '2024-03-24', '14:47:00'),
(21, 3, 7, 18, 'createnft', '-', 3, '3', '-', '2024-03-24', '14:50:00'),
(22, 3, 8, 0, 'createcollection', '8', 0, '3', '-', '2024-03-24', '15:05:00'),
(23, 3, 8, 19, 'createnft', '-', 1, '3', '-', '2024-03-24', '15:07:00'),
(24, 3, 8, 20, 'createnft', '-', 1, '3', '-', '2024-03-24', '15:10:00'),
(25, 1, 9, 0, 'createcollection', '9', 0, '1', '-', '2024-03-24', '15:27:00'),
(26, 1, 9, 21, 'createnft', '-', 1, '1', '-', '2024-03-24', '15:28:00'),
(27, 3, 10, 0, 'createcollection', '10', 0, '3', '-', '2024-03-24', '16:43:00'),
(28, 3, 10, 22, 'createnft', '-', 1, '3', '-', '2024-03-24', '16:44:00'),
(29, 3, 11, 0, 'createcollection', '11', 0, '3', '-', '2024-03-24', '17:10:00'),
(30, 3, 11, 23, 'createnft', '-', 1, '3', '-', '2024-03-24', '17:10:00'),
(31, 3, 11, 24, 'createnft', '-', 1, '3', '-', '2024-03-24', '17:13:00'),
(32, 3, 12, 0, 'createcollection', '12', 0, '3', '-', '2024-03-24', '17:19:00'),
(33, 3, 12, 25, 'createnft', '-', 2, '3', '-', '2024-03-24', '17:20:00'),
(34, 1, 13, 0, 'createcollection', '13', 0, '1', '-', '2024-03-24', '17:30:00'),
(35, 1, 13, 28, 'createnft', '-', 1, '1', '-', '2024-03-24', '17:40:00'),
(36, 1, 13, 29, 'createnft', '-', 1, '1', '-', '2024-03-24', '17:44:00'),
(37, 2, 14, 0, 'createcollection', '14', 0, '2', '-', '2024-03-24', '18:06:00'),
(38, 2, 14, 30, 'createnft', '-', 1, '2', '-', '2024-03-24', '18:10:00'),
(39, 2, 14, 31, 'createnft', '-', 1, '2', '-', '2024-03-24', '18:17:00'),
(40, 2, 15, 0, 'createcollection', '15', 0, '2', '-', '2024-03-24', '18:21:00'),
(41, 2, 15, 32, 'createnft', '-', 1, '2', '-', '2024-03-24', '18:24:00'),
(42, 2, 16, 0, 'createcollection', '16', 0, '2', '-', '2024-03-24', '18:36:00'),
(43, 2, 16, 33, 'createnft', '-', 1, '2', '-', '2024-03-24', '18:37:00'),
(44, 2, 16, 34, 'createnft', '-', 1, '2', '-', '2024-03-24', '18:39:00'),
(45, 1, 11, 23, 'sale', NULL, 1, '3', '1', '2024-03-27', '10:25:08'),
(46, 3, 1, 2, 'sale', NULL, 1, '1', '3', '2024-03-29', '18:27:19'),
(47, 3, 17, 0, 'createcollection', '17', 0, '3', '-', '2024-04-08', '12:48:00'),
(48, 3, 17, 35, 'createnft', '-', 1, '3', '-', '2024-04-08', '12:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `articleid` int(11) NOT NULL,
  `articleimage` varchar(255) NOT NULL,
  `articlename` varchar(255) NOT NULL,
  `articlecategory` varchar(255) NOT NULL,
  `articlestandard` varchar(255) NOT NULL,
  `articleabout` longtext NOT NULL,
  `articledate` date NOT NULL,
  `articletime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`articleid`, `articleimage`, `articlename`, `articlecategory`, `articlestandard`, `articleabout`, `articledate`, `articletime`) VALUES
(1, 'Assets/articles/what-is-nft.png', 'What is an NFT?', 'nft', 'beginner', ' Fungible vs. non-fungible\r\nBefore we dive into NFTs, it’s important to understand the “non-fungible” part of “non-fungible token.” When an item is fungible, it means it’s interchangeable with another of the same item. A classic example is a $1 dollar bill: you could swap dollars with someone and you’d both still have $1.\r\n\r\nNon-fungible, on the other hand, means the item is totally unique, and therefore has its own unique value. For example, two cars of the same make and model might have different values based on how many miles are on the odometer, their accident records, or if it was previously owned by a celebrity. \r\n\r\nHow do NFTs work?\r\nNFTs operate on blockchain technology. The blockchain is basically a large, digital, public record. The most popular blockchains are distributed across many nodes (read: people’s computers), which is why you’ll hear them described as “decentralized.” \r\n\r\nSo instead of a central company-owned server, the blockchain is distributed across a peer-to-peer network. Not only does this ensure that the blockchain remains immutable, it also allows the node operators to earn money, instead of a single company. Because the blockchain records and preserves history, it is uniquely positioned to transform provable authenticity and digital ownership.', '2024-03-24', '11:13:17'),
(2, 'Assets/articles/blockchain.png', 'What are blockchain forks', 'blockchain', 'advanced', 'In the blockchain ecosystem, blockchain forks are community-driven changes to the codebases or protocols of the blockchains that usually alter their function in a meaningful way.', '2024-03-24', '11:21:54'),
(3, 'Assets/articles/PROFILE PICTURE NFT 101.png', 'What are profile picture (PFP) NFTs?', 'nft', 'intermediate', 'What defines a PFP NFT?\r\nA profile picture, or PFP, NFT is any NFT thats primary purpose is use as a social media profile picture, or avatar. These NFTs are digital items that are authenticated on a blockchain network, making them verifiably unique. Some PFP NFTs also grant access to designated online communities. \r\n\r\nProfile picture NFTs come in various forms, ranging from static images to animated or interactive designs. They may be based on characters, take the form of animals, look like humans, or be abstract.\r\n\r\nHow are PFP NFTs made?\r\nIn many cases, creators use generative art technology to create a library of characteristics (or character features) that can be remixed into endless unique NFTs within a collection. \r\n\r\nGenerative art refers to art that’s created using an algorithm or set of rules. It can be created using a wide range of techniques and technologies, including code and artificial intelligence. The creator creates a set of rules or instructions that define the parameters for generating the artwork. These parameters can include things like color, shape, size, and movement, among others. Once the rules have been defined, the algorithm takes over, producing a series of images or animations based on the parameters set by the creator. Generative art allows creators to make large collections (for example, a 10,000 NFT collection) that all have unique traits and levels of rarity while retaining a specific art style and look.', '2024-03-24', '11:23:55'),
(4, 'Assets/articles/PG-nft.png', 'What are photography NFTs?', 'nft', 'beginner', 'What is an NFT?\r\nAn NFT is a unique digital item stored on a blockchain. NFTs can represent almost anything and serve as a digital record of ownership.\r\n\r\nPhotography NFTs can be created by beginner and professional photographers alike. These NFTs can include anything from a photo, to a GIF or video, to a blend of photography and another medium like AI or drawing. The content of each photography NFT varies based on the creator and the work they decide to create.\r\n\r\nWhat are the advantages of using blockchains for photography NFTs?\r\nAuthenticity and provenance\r\nBy using a blockchain to track the ownership and movement of a photography NFT, it is possible to establish a clear and verifiable record of the authenticity and provenance of the artwork.\r\n\r\nImmutability\r\nOnce an NFT is recorded on a blockchain, its record cannot be altered or deleted. This ensures the authenticity and ownership of the NFT and ties it to its creator.\r\n\r\nDecentralization\r\nBlockchains are decentralized systems. This can help to ensure fairness and transparency in the distribution and ownership of photography NFTs.\r\n\r\nVerification\r\nThe use of smart contracts on a blockchain can facilitate the verification of NFT ownership and facilitate transactions in a transparent and secure manner.', '2024-03-24', '11:40:50'),
(5, 'Assets/articles/stay-protacted.png', 'How to stay protected in web3', 'web3', 'beginner', 'Web3 technology is still new, and it’s constantly evolving, so while there’s no single action that guarantees protection, there are best practices that can help. Never share your wallet’s seed phrase, be careful when taking actions using your wallet, and make sure to thoroughly evaluate NFTs before buying. The best rule of thumb is that if something looks too good to be true, it probably is.\r\n\r\nHow can I protect my crypto wallet?\r\nLet’s start with wallets. A crypto wallet is a program that helps you buy, sell, and store your cryptocurrency and (in many cases) your NFTs. Think of it as your address on the blockchain — you can send and receive items from it, it stores your items, and you want to keep it locked and safe. \r\n\r\nThere are many kinds of wallets: custodial and non-custodial, hardware and software, and some wallets that are only compatible with specific chains. \r\n\r\nNon-custodial wallets will provide you with a seed phrase, which is your unique access key. Some wallets call this a backup phrase, secret recovery phrase, or even a mnemonic sentence, but they all operate on the same concept: your seed phrase will appear as a string of words in a specific order. \r\n\r\nOnce you receive your seed phrase, you’ll need to store it in a safe place that no one else will be able to access. This may mean writing it down on a piece of paper, analog style, and keeping it somewhere safe, or even keeping it in more than one safe location. Never share your seed phrase with anyone — verbally, visually, digitally, or otherwise — because it will give them access to your wallet and everything it holds. ', '2024-03-24', '11:45:23'),
(6, 'Assets/articles/smart-contract.png', 'What is a smart contract?', 'blockchain', 'beginner', 'What is a smart contract?\r\nHistorically, banks and institutions provided a key function in our world’s many transactions. From money transfers to legal deeds, the ability of the parties to fulfill their respective part of the agreed-upon transaction has been assessed by each bank or institution’s own set of rules (whether the rules were fully public or not). And records of transactions or agreements of many kinds have typically been stored in centralized databases, where they are accessible only to certain parties.\r\n\r\nBut web3 and crypto are introducing a new way. What if the success or failure of transactions could be assessed through pre-programmed code based on the parameters of the parties’ agreed-upon transaction including details like how much items cost, where payment is sent and who authorizes the transaction?\r\n\r\nWelcome to the future, where transparent, decentralized code can help perform some of the duties that humans have historically completed with more centralized guidelines and record keeping. This kind of programmability is possible through the use of smart contracts, automated computer programs that run on blockchains. \r\n\r\nSmart contracts are a core part of the on-chain code that powers non-fungible tokens (NFTs), decentralized applications (dApps), and decentralized finance (DeFi) protocols. The term “smart contract” dates back two decades. Nick Szabo, a cryptographer and computer scientist, coined the term as a graduate student at the University of Washington. He wrote that smart contracts would be defined by “a set of promises, specified in digital form, including protocols within which the parties perform on these promises.” In practice, those promises, or rules, are what enable what we see in NFTs’ functionality and more.\r\n\r\nFor instance, a smart contract helps track an NFT’s ownership records, making it possible to verify and easily transfer the digital item from one owner to the next without the need for a third-party intermediary. \r\n\r\nSmart contracts exist on the blockchain, a digitally distributed ledger that records transactions and information across a decentralized network. Most blockchains are verified by many nodes (read: computers), which is why you’ll hear them described as “decentralized.” Different blockchains may verify their transactions using different methods but ultimately operate similarly. ', '2024-03-24', '11:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `auctionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `auctioncreatedate` date NOT NULL,
  `auctioncreatetime` time NOT NULL,
  `auctionenddate` date NOT NULL,
  `auctionendtime` time NOT NULL,
  `auctionstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auctionid`, `userid`, `nftid`, `auctioncreatedate`, `auctioncreatetime`, `auctionenddate`, `auctionendtime`, `auctionstatus`) VALUES
(1, 3, 23, '2024-03-27', '10:20:50', '2024-03-28', '10:21:00', 'close'),
(2, 3, 24, '2024-03-28', '09:40:06', '2024-03-28', '09:45:00', 'close'),
(3, 3, 24, '2024-03-28', '09:48:25', '2024-03-29', '09:49:00', 'deactive'),
(4, 3, 24, '2024-03-28', '09:59:06', '2024-03-28', '10:00:00', 'close'),
(5, 1, 2, '2024-03-29', '13:43:21', '2024-03-30', '13:43:00', 'close'),
(6, 3, 20, '2024-03-29', '20:03:25', '2024-03-30', '20:05:00', 'close'),
(7, 3, 2, '2024-04-07', '10:43:50', '2024-04-08', '10:44:00', 'deactive');

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `userimage` varchar(255) DEFAULT NULL,
  `userbackimage` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userabout` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_role` varchar(20) DEFAULT 'user',
  `joindate` date NOT NULL,
  `jointime` time NOT NULL,
  `deactivationdate` date NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `accept_terms` tinyint(1) DEFAULT NULL,
  `strikes` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `userimage`, `userbackimage`, `username`, `userabout`, `firstname`, `lastname`, `phone`, `gender`, `email`, `password`, `user_role`, `joindate`, `jointime`, `deactivationdate`, `status`, `accept_terms`, `strikes`) VALUES
(1, 'Assets/Auth/person.png', 'Assets/background/001.png', 'admin', 'Hi, I am Admin...', 'Vivek', 'Surati', '1234567890', 'male', 'nftmarketplace@gmail.com', '$2y$10$9UrXl3v.aLL3CGrqJvX9TueNz0xTGSMBmwf0yHs4jdqhHb0Vn8Oiy', 'admin', '2024-03-24', '11:12:59', '0000-00-00', NULL, 1, NULL),
(2, 'Assets/Auth/IMG_2023-01-14-15-19-12-319.jpg', NULL, 'jay_', NULL, 'Jay', 'Surati', '1234567891', 'male', 'jay@gmail.com', '$2y$10$o7Xj295mljOfWy1d0LOK.OSDmMm3YlhAcUgdzCYr4ykt30fJBfEyW', 'user', '2024-03-24', '12:15:04', '2024-04-15', 'strike', 1, '2'),
(3, 'Assets/Auth/BEN 10 PFP.PNG', NULL, 'vivek', NULL, 'vivek', 'surati', '1234567892', 'male', 'vivek@gmail.com', '$2y$10$AGXWvqEz.PMx8lAIdbd9TOj9F3uugn6CsCi92tRts5w4o.0aMTovm', 'user', '2024-03-24', '14:37:35', '2024-04-22', 'strike', 1, '3');

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `biddingid` int(11) NOT NULL,
  `bidderid` int(11) NOT NULL,
  `auctionid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `bidprice` decimal(10,2) NOT NULL,
  `biddate` date NOT NULL,
  `bidtime` time NOT NULL,
  `bidstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bidding`
--

INSERT INTO `bidding` (`biddingid`, `bidderid`, `auctionid`, `nftid`, `bidprice`, `biddate`, `bidtime`, `bidstatus`) VALUES
(1, 1, 1, 23, 145.00, '2024-03-27', '10:22:24', 'accept'),
(2, 1, 2, 24, 50.00, '2024-03-28', '09:40:38', 'accept'),
(3, 1, 2, 24, 51.00, '2024-03-28', '09:43:01', 'accept'),
(4, 1, 2, 24, 52.00, '2024-03-28', '09:43:55', 'accept'),
(5, 1, 3, 24, 50.00, '2024-03-28', '09:48:54', 'accept'),
(6, 1, 3, 24, 51.00, '2024-03-28', '09:49:19', 'accept'),
(7, 1, 3, 24, 52.00, '2024-03-28', '09:58:12', 'bidded'),
(8, 1, 4, 24, 50.00, '2024-03-28', '09:59:19', 'accept'),
(9, 3, 5, 2, 170.00, '2024-03-29', '14:00:03', 'accept'),
(10, 3, 5, 2, 175.00, '2024-03-29', '14:00:19', 'accept'),
(11, 1, 6, 20, 236.00, '2024-03-29', '20:04:27', 'accept'),
(12, 1, 6, 20, 240.00, '2024-03-29', '20:04:42', 'accept'),
(13, 1, 7, 2, 169.00, '2024-04-07', '10:44:35', 'bidded');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faqid` int(11) NOT NULL,
  `faqimage` varchar(255) NOT NULL,
  `faqtitle` varchar(255) NOT NULL,
  `faqdescription` text NOT NULL,
  `created_date` date NOT NULL,
  `created_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faqid`, `faqimage`, `faqtitle`, `faqdescription`, `created_date`, `created_time`) VALUES
(1, 'what-is-nft.png', 'What Is an NFT?', 'An NFT (non-fungible token) is a unique digital item stored on a blockchain. NFTs can represent almost anything, and serve as a digital record of ownership.', '2024-03-24', '11:13:00'),
(2, 'blockchain.png', 'What are blockchain forks', 'In the blockchain ecosystem, blockchain forks are community-driven changes to the codebases or protocols of the blockchains that usually alter their function in a meaningful way.', '2024-03-24', '11:22:00'),
(3, 'PROFILE PICTURE NFT 101.png', 'What are PFP NFTs?', 'Profile picture (PFP) NFTs are digital items that represent ownership of a unique and collectible image or piece of artwork that can be used as a profile picture. Profile picture NFTs can be used as an avatar, a collectible, or can serve as membership to a community.', '2024-03-24', '11:24:00'),
(4, 'PG-nft.png', 'What are photography NFTs?', 'A photography NFT (non-fungible token) is a digital item that represents a digital photograph or moving image. Photography NFTs are typically created and sold by photographers or visual artists as a way to distribute their work in a digital format. NFTs are stored on a blockchain, which is a decentralized, distributed ledger that allows for the creation, verification, and transfer of digital items.', '2024-03-24', '11:41:00'),
(5, 'stay-protacted.png', 'How to stay protected in web3', 'Web3 technology is still new, and it’s constantly evolving, so while there’s no single action that guarantees protection, there are best practices that can help. Never share your wallet’s seed phrase, be careful when taking actions using your wallet, and make sure to thoroughly evaluate NFTs before buying. The best rule of thumb is that if something looks too good to be true, it probably is.', '2024-03-24', '11:45:00'),
(6, 'smart-contract.png', 'What is a smart contract?', 'Smart contracts are blockchain-based automated computer programs that enforce their coded rules. Using “if this, then that” logic, smart contracts power NFTs and dApps on the blockchain. Buying and selling NFTs using OpenSea is powered by the smart contract protocol, Seaport.', '2024-03-24', '11:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `nftid`, `userid`) VALUES
(3, 28, 1),
(4, 28, 3),
(5, 3, 3),
(6, 5, 3),
(7, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loginhistory`
--

CREATE TABLE `loginhistory` (
  `loginid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `logindate` date NOT NULL,
  `logintime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginhistory`
--

INSERT INTO `loginhistory` (`loginid`, `userid`, `logindate`, `logintime`) VALUES
(1, 1, '2024-03-24', '11:13:00'),
(2, 2, '2024-03-24', '12:15:00'),
(3, 1, '2024-03-24', '12:29:00'),
(4, 2, '2024-03-24', '12:30:00'),
(5, 1, '2024-03-24', '13:03:00'),
(6, 3, '2024-03-24', '14:38:00'),
(7, 3, '2024-03-24', '16:17:00'),
(8, 1, '2024-03-24', '16:17:00'),
(9, 3, '2024-03-24', '17:23:00'),
(10, 2, '2024-03-24', '18:04:00'),
(11, 2, '2024-03-26', '15:13:00'),
(12, 2, '2024-03-26', '15:23:00'),
(13, 2, '2024-03-26', '15:24:00'),
(14, 2, '2024-03-26', '15:25:00'),
(15, 2, '2024-03-26', '15:27:00'),
(16, 2, '2024-03-26', '15:28:00'),
(17, 2, '2024-03-26', '15:29:00'),
(18, 2, '2024-03-26', '15:29:00'),
(19, 2, '2024-03-26', '15:29:00'),
(20, 2, '2024-03-26', '15:30:00'),
(21, 2, '2024-03-26', '15:30:00'),
(22, 1, '2024-03-26', '15:39:00'),
(23, 2, '2024-03-26', '16:03:00'),
(24, 2, '2024-03-26', '16:07:00'),
(25, 2, '2024-03-26', '16:20:00'),
(26, 2, '2024-03-26', '16:21:00'),
(27, 2, '2024-03-26', '16:28:00'),
(28, 1, '2024-03-26', '16:45:00'),
(29, 3, '2024-03-26', '17:33:00'),
(30, 2, '2024-03-27', '08:22:00'),
(31, 2, '2024-03-27', '08:40:00'),
(32, 2, '2024-03-27', '08:41:00'),
(33, 1, '2024-03-27', '10:13:00'),
(34, 3, '2024-03-27', '10:17:00'),
(35, 3, '2024-03-28', '17:47:00'),
(36, 1, '2024-03-29', '11:46:00'),
(37, 3, '2024-03-29', '13:45:00'),
(38, 1, '2024-04-01', '18:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `nft`
--

CREATE TABLE `nft` (
  `nftid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `collectionid` int(11) DEFAULT NULL,
  `royaltyid` int(11) NOT NULL,
  `nftimage` varchar(255) NOT NULL,
  `nftname` varchar(255) NOT NULL,
  `nftsupply` int(11) NOT NULL,
  `nftprice` decimal(10,2) NOT NULL,
  `nftfloorprice` decimal(10,2) NOT NULL,
  `nftdescription` text NOT NULL,
  `nftstatus` varchar(255) NOT NULL,
  `nftcreated_date` date NOT NULL,
  `nftcreated_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nft`
--

INSERT INTO `nft` (`nftid`, `userid`, `collectionid`, `royaltyid`, `nftimage`, `nftname`, `nftsupply`, `nftprice`, `nftfloorprice`, `nftdescription`, `nftstatus`, `nftcreated_date`, `nftcreated_time`) VALUES
(1, 1, 1, 0, 'Assets/NFTs/Anichess Orbs of Power - Pawn of Water.jpg', 'Pawn of Water', 1, 149.00, 149.00, 'Like a single drop in an ocean, the Pawn of Water may appear small, but in unity, it forms an unbeatable force.', 'active', '2024-03-24', '11:40:00'),
(2, 3, 1, 1, 'Assets/NFTs/Anichess Orbs of Power - Knight of Fire.jpg', 'Knight of Fire', 1, 168.00, 160.00, 'Unleash the fiery might, forged in the heart of battle.', 'active', '2024-03-24', '11:43:00'),
(3, 1, 1, 0, 'Assets/NFTs/Anichess Orbs of Power - King Of Aether.jpg', 'King Of Aether', 1, 199.00, 199.00, 'Ascend to rule the skies, crowned King of Aether.\r\n', 'active', '2024-03-24', '11:45:00'),
(4, 2, 2, 0, 'Assets/NFTs/pg - animal 1.jpg', 'Flickerflare, the mischievous Emberwhisker.', 1, 99.00, 99.00, 'Flickerflare, the mischievous Emberwhisker.', 'active', '2024-03-24', '12:34:00'),
(5, 2, 2, 0, 'Assets/NFTs/pg - animal  2.jpg', 'Roarheart, the mighty Forest Titan', 1, 149.00, 149.00, 'Roarheart, the mighty Forest Titan', 'active', '2024-03-24', '12:36:00'),
(6, 2, 2, 0, 'Assets/NFTs/pg - animal  3.jpg', 'Whiskerwhirl, the elusive Shadow Prowler', 1, 249.00, 249.00, 'Whiskerwhirl, the elusive Shadow Prowler', 'active', '2024-03-24', '12:38:00'),
(7, 1, 3, 0, 'Assets/NFTs/dbz - black goku.jpg', 'Black Goku', 1, 125.00, 125.00, 'Darkened Fury, the Shadow Saiyan.', 'active', '2024-03-24', '13:09:00'),
(8, 1, 3, 0, 'Assets/NFTs/dbz - vegeta.jpg', 'Prince of Power, the Saiyan Sovereign', 1, 140.00, 140.00, 'Prince of Power, the Saiyan Sovereign.', 'active', '2024-03-24', '13:20:00'),
(9, 1, 4, 0, 'Assets/NFTs/pokemon pfp - squrtle.png', 'Aquashell - the Torrential Guardian', 1, 259.00, 259.00, 'Aquashell - the Torrential Guardian', 'active', '2024-03-24', '13:32:00'),
(10, 1, 4, 0, 'Assets/NFTs/pokemon pfp - charmender.png', 'Emberflare - the Fiery Spirit', 1, 198.00, 198.00, 'Emberflare, the Fiery Spirit.', 'active', '2024-03-24', '13:34:00'),
(11, 1, 4, 0, 'Assets/NFTs/pokemon - evee.gif', 'Echofur - the Versatile Wanderer', 1, 189.00, 189.00, 'Echofur, the Versatile Wanderer', 'active', '2024-03-24', '13:37:00'),
(12, 2, 5, 0, 'Assets/NFTs/ben 10 PFP - heatblast.jpg', 'Inferno Fury - the Blazing Titan', 1, 239.00, 239.00, 'Inferno Fury, the Blazing Titan', 'active', '2024-03-24', '13:44:00'),
(13, 2, 5, 0, 'Assets/NFTs/ben 10 php - rath.png', 'Rampage Roar - the Unstoppable Berserker', 1, 135.00, 135.00, 'Rampage Roar, the Unstoppable Berserker.', 'active', '2024-03-24', '13:47:00'),
(14, 1, 6, 0, 'Assets/NFTs/coc - barbarian.jpg', 'Grommash Bloodaxe', 1, 234.00, 234.00, 'Grommash Bloodaxe', 'active', '2024-03-24', '13:52:00'),
(15, 1, 6, 0, 'Assets/NFTs/coc - wizard.jpg', 'Merlin Spellweaver', 1, 148.00, 148.00, 'The Arcane Sage of Mysteries', 'active', '2024-03-24', '13:58:00'),
(16, 3, 7, 0, 'Assets/NFTs/Free Fire - Magic.jpg', 'FF - Magic', 1, 249.00, 249.00, 'Step into a realm where spells ignite and mysteries unfold. FF Magic takes you on an enchanting journey through realms of fire and fantasy', 'active', '2024-03-24', '14:44:00'),
(17, 3, 7, 0, 'Assets/NFTs/Free Fire - Venum.jpg', 'FF - Venom 3', 1, 149.00, 149.00, 'Venomstrike, the Sinister Symbiote.', 'active', '2024-03-24', '14:47:00'),
(18, 3, 7, 0, 'Assets/NFTs/Free Fire - Wolfrahh.jpg', 'FF - Woolfarahh', 3, 89.00, 89.00, '\"Stormwind Sentinel, the Swift Guardian of the Desert Sands.\"', 'active', '2024-03-24', '14:49:00'),
(19, 3, 8, 0, 'Assets/NFTs/Froza Horizon 5 - MCLAREN SPEEDTAIL 2019.jpg', 'FH5 - McLaren Speedtail', 1, 249.00, 249.00, 'Unleash the Future - FH5s McLaren Speedtail Experience', 'active', '2024-03-24', '15:07:00'),
(20, 3, 8, 0, 'Assets/NFTs/Froza Horizon 5 - BUGATTI DIVO 2019.jpg', 'FH5 - Bugatti Divo', 1, 235.00, 235.00, '\"FH5: Conquer the Roads with the Bugatti Divo.\"', 'active', '2024-03-24', '15:10:00'),
(21, 1, 9, 0, 'Assets/NFTs/Art - Ai images - background.png', 'Aurora', 1, 49.00, 49.00, '\"DigiCanvas: Where Non-Fungible Treasures Await.\"', 'active', '2024-03-24', '15:28:00'),
(22, 3, 10, 0, 'Assets/NFTs/pg - flower 1.jpg', 'Solar Bloom Spectacular', 1, 89.00, 89.00, 'Behold the Solar Bloom Spectacular, a mesmerizing array of yellow flowers that dance under the sun gentle caress', 'active', '2024-03-24', '16:44:00'),
(23, 1, 11, 3, 'Assets/NFTs/A - Frenly Pandas - Dr Panda.png', 'Frenly Pandas 001', 1, 145.00, 139.00, 'These gentle creatures are more than just adorable bears', 'active', '2024-03-24', '17:10:00'),
(24, 3, 11, 0, 'Assets/NFTs/A - Frenly Pandas - Ms Panda.png', 'Frenly Pandas 002', 1, 49.00, 48.00, 'These gentle creatures are more than just adorable bears', 'active', '2024-03-24', '17:13:00'),
(25, 3, 12, 0, 'Assets/NFTs/NFT 001 - Pudgy Rod.png', 'Pudgy Rod 001', 2, 48.00, 48.00, 'the ultimate fishing companions for those who appreciate a bit of whimsy and charm in their angling adventures. ', 'active', '2024-03-24', '17:20:00'),
(26, 1, 13, 0, 'Assets/NFTs/G - asphalt 9 - Lamborghini.jpg', 'A9 - Lamborghini', 1, 289.00, 289.00, 'you will tear up the tracks in some of the worlds most iconic locations.', 'pending', '2024-03-24', '17:36:00'),
(27, 1, 13, 0, 'Assets/NFTs/G - asphalt 9 - Lamborghini.jpg', 'A9 - Lamborghini', 1, 299.00, 299.00, 'Adrenaline Rush!', 'pending', '2024-03-24', '17:38:00'),
(28, 1, 13, 0, 'Assets/NFTs/G - asphalt 9 - Lamborghini.jpg', 'A9 - Lamborghini', 1, 299.00, 189.00, 'A9 - Lamborghini', 'active', '2024-03-24', '17:40:00'),
(29, 1, 13, 0, 'Assets/NFTs/G - asphalt 9 - Lamborghini Veneno.jpg', 'A9 - Lamborghini Veneno', 1, 349.00, 349.00, 'A9 - Lamborghini Veneno', 'active', '2024-03-24', '17:44:00'),
(30, 2, 14, 0, 'Assets/NFTs/A - The Buns - Hefty Hares - 001.png', 'The BUN 001', 1, 49.00, 49.00, 'The Buns - Hefty Hares', 'active', '2024-03-24', '18:10:00'),
(31, 2, 14, 0, 'Assets/NFTs/pfp - The Buns - Hefty Hares - 001.png', 'The Bun 002', 1, 58.00, 58.00, 'Buns Fury\r\n', 'active', '2024-03-24', '18:14:00'),
(32, 2, 15, 0, 'Assets/NFTs/A - indian Art - 001.jpg', ' Opulent Plumage - The Peacocks Pride', 1, 149.00, 149.00, 'Enter the realm of Opulent Plumage - The Peacocks Pride, where the majestic beauty of the peacock is celebrated in all its resplendent glory.', 'active', '2024-03-24', '18:24:00'),
(33, 2, 16, 0, 'Assets/NFTs/PG - anciant temple - 001.png', 'Sanctum of Ancients 001', 1, 248.00, 248.00, 'Sanctum of Ancients 001 stands as a solitary sentinel amidst the veils of time', 'active', '2024-03-24', '18:37:00'),
(34, 2, 16, 0, 'Assets/NFTs/PG - anciant temple - 002.png', 'Sanctum of Ancients 002', 1, 149.00, 149.00, 'Sanctum of Ancients 002 stands as a solitary sentinel amidst the veils of time', 'active', '2024-03-24', '18:39:00'),
(35, 3, 17, 0, 'Assets/NFTs/Froza Horizon 5 - BUGATTI DIVO 2019.jpg', 'Car 1', 1, 89.00, 89.00, 'the cars', 'active', '2024-04-08', '12:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `nftactivity`
--

CREATE TABLE `nftactivity` (
  `transferid` int(11) NOT NULL,
  `autherid` int(11) NOT NULL,
  `currentautherid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `nftprice` decimal(10,2) NOT NULL,
  `nftsupply` varchar(255) NOT NULL,
  `activitydate` date NOT NULL,
  `activitytime` time NOT NULL,
  `nftactivitystatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nftactivity`
--

INSERT INTO `nftactivity` (`transferid`, `autherid`, `currentautherid`, `nftid`, `nftprice`, `nftsupply`, `activitydate`, `activitytime`, `nftactivitystatus`) VALUES
(1, 3, 1, 23, 145.00, '1', '2024-03-27', '10:25:08', 'sale'),
(2, 3, 1, 23, 0.00, '-', '2024-03-27', '10:25:08', 'transfer'),
(3, 1, 3, 2, 168.00, '1', '2024-03-29', '18:27:19', 'sale'),
(4, 1, 3, 2, 0.00, '-', '2024-03-29', '18:27:19', 'transfer');

-- --------------------------------------------------------

--
-- Table structure for table `nftcollected`
--

CREATE TABLE `nftcollected` (
  `collectid` int(11) NOT NULL,
  `autherid` int(11) NOT NULL,
  `currentautherid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `nftprice` decimal(10,2) NOT NULL,
  `nftsupply` varchar(255) NOT NULL,
  `collectdate` date NOT NULL,
  `collecttime` time NOT NULL,
  `collectstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nftcollected`
--

INSERT INTO `nftcollected` (`collectid`, `autherid`, `currentautherid`, `nftid`, `nftprice`, `nftsupply`, `collectdate`, `collecttime`, `collectstatus`) VALUES
(1, 3, 1, 23, 145.00, '1', '2024-03-27', '10:25:08', 'saled'),
(2, 1, 0, 23, 145.00, '1', '2024-03-27', '10:25:08', 'saled'),
(3, 1, 3, 2, 168.00, '1', '2024-03-29', '18:27:19', 'saled'),
(4, 3, 0, 2, 168.00, '1', '2024-03-29', '18:27:19', 'collected');

-- --------------------------------------------------------

--
-- Table structure for table `nftcollection`
--

CREATE TABLE `nftcollection` (
  `collectionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `collectionimage` varchar(255) NOT NULL,
  `collectionbackground` varchar(255) NOT NULL,
  `collectionname` varchar(255) NOT NULL,
  `collectiondescription` varchar(255) NOT NULL,
  `collectionblockchain` varchar(50) NOT NULL,
  `collectioncategory` varchar(50) NOT NULL,
  `collectionStatus` varchar(255) DEFAULT 'pending',
  `collectionDeployCharge` decimal(10,2) DEFAULT 149.00,
  `collection_created_date` date NOT NULL,
  `collection_created_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nftcollection`
--

INSERT INTO `nftcollection` (`collectionid`, `userid`, `collectionimage`, `collectionbackground`, `collectionname`, `collectiondescription`, `collectionblockchain`, `collectioncategory`, `collectionStatus`, `collectionDeployCharge`, `collection_created_date`, `collection_created_time`) VALUES
(1, 1, 'Assets/NFTCollection/Anichess Orbs of Power.png', 'Assets/NFTCollection/Anichess Orbs of Power - Background.png', 'Anichess Orbs of Power', 'Orbs of Power are the first set of digital collectibles in the Anichess Universe. Each Orb of Power contains unique magic installed by its creator and holds the power to shape the Universe. ', 'inr', 'gaming', 'active', 149.00, '2024-03-24', '11:38:00'),
(2, 2, 'Assets/NFTCollection/pg - animal.png', 'Assets/NFTCollection/pg - animal - background.png', 'Doeksen Animals', 'Embrace the wild essence of Doeksen creatures. Where every heartbeat echoes the rhythm of nature symphony.', 'inr', 'photography', 'active', 149.00, '2024-03-24', '12:33:00'),
(3, 1, 'Assets/NFTCollection/DBZ PFP.png', 'Assets/NFTCollection/DBZ PFP - background.jpg', 'DBz - The Cosmic Blast', 'In \"DBz - The Cosmic Blast,\" embark on an intergalactic journey where the fate of the universe hangs in the balance. Set in the expansive Dragon Ball Z universe, this thrilling adventure pits our beloved heroes against a new and formidable cosmic threat.', 'inr', 'pfp', 'active', 149.00, '2024-03-24', '13:08:00'),
(4, 1, 'Assets/NFTCollection/Pokemon PFP.png', 'Assets/NFTCollection/Pokemon PFP background 2.png', ' Pokémon', 'Welcome to the vibrant world of Pixelmon Prism, where digital artistry meets the enchanting realm of Pokémon. Each Pixelmon Prism NFT is a unique masterpiece, capturing the essence of beloved Pokémon in a pixelated wonderland.', 'inr', 'pfp', 'active', 149.00, '2024-03-24', '13:31:00'),
(5, 2, 'Assets/NFTCollection/BEN 10 PFP.PNG', 'Assets/NFTCollection/ben 10 PFP - fourarms.gif', 'Omniverse Conqueror', 'Dive into boundless adventures with the Omniverse Conqueror: Hyperfusion Arsenal. Harness the might of aliens and technology in your hands. Become the hero of limitless worlds!', 'inr', 'pfp', 'active', 149.00, '2024-03-24', '13:43:00'),
(6, 1, 'Assets/NFTCollection/coc.png', 'Assets/NFTCollection/coc - background.jpg', 'Clash Craze Chronicles', 'Dive into the Clash Craze Chronicles, where legends are forged and kingdoms clash in epic battles of strategy and wit. This collection celebrates the heart-pounding excitement and boundless creativity of Clash of Clans, bringing together a diverse array o', 'inr', 'gaming', 'active', 149.00, '2024-03-24', '13:51:00'),
(7, 3, 'Assets/NFTCollection/Free Fire.png', 'Assets/NFTCollection/Free Fire - background 3.png', 'Inferno Ignition', '\"Inferno Ignition: The Blazing Frenzy Collection.\"', 'inr', 'gaming', 'active', 149.00, '2024-03-24', '14:42:00'),
(8, 3, 'Assets/NFTCollection/Forza Horizon 5-2.png', 'Assets/NFTCollection/Forza Horizon 5 - background.jpg', 'Forza Horizon 5', '\"Unleash the Horizon: Forza Ultimate Playground.\"', 'inr', 'gaming', 'active', 149.00, '2024-03-24', '15:04:00'),
(9, 1, 'Assets/NFTCollection/Art - Ai images - background.png', 'Assets/NFTCollection/Art - Ai images - background.png', 'PixelPulse', '\"PixelPulse: Where AI Breathes Art into Reality.\"', 'inr', 'art', 'active', 149.00, '2024-03-24', '15:27:00'),
(10, 3, 'Assets/NFTCollection/pg - sunshine.jpg', 'Assets/NFTCollection/pg - sunshine - background.jpg', 'Radiant Lens Revelry', 'an enchanting collection of photography that captures the essence of sunshine in its myriad forms. Here, each image is a vibrant celebration of light and its transformative power on the world around us.', 'inr', 'photography', 'active', 149.00, '2024-03-24', '16:43:00'),
(11, 3, 'Assets/NFTCollection/A - Frenly Pandas.png', 'Assets/NFTCollection/A - Frenly Pandas - background.png', 'Frenly Pandas', 'Home to the most friendly and endearing pandas you will ever encounter. In this tranquil sanctuary nestled amidst bamboo forests and rolling hills, the Harmony Haven Pandas live in perfect harmony with nature and each other.', 'inr', 'art', 'active', 149.00, '2024-03-24', '17:09:00'),
(12, 3, 'Assets/NFTCollection/Pudgy Rods.png', 'Assets/NFTCollection/pudgy road background.png', 'Pudgy Rods', 'the ultimate fishing companions for those who appreciate a bit of whimsy and charm in their angling adventures. ', 'inr', 'art', 'active', 149.00, '2024-03-24', '17:19:00'),
(13, 1, 'Assets/NFTCollection/G - Asphalt 9.jpg', 'Assets/NFTCollection/G - Asphalt 9 - background.jpg', 'Asphalt 9', 'Adrenaline Rush! In this heart-pounding sequel to the acclaimed Asphalt series, you will tear up the tracks in some of the worlds most iconic locations, pushing the limits of speed and precision in blistering races that will leave you breathless.', 'inr', 'gaming', 'active', 149.00, '2024-03-24', '17:30:00'),
(14, 2, 'Assets/NFTCollection/A - The Buns - Hefty Hares.png', 'Assets/NFTCollection/A - The Buns - Hefty Hares - BG.png', 'The Buns - Hefty Hares', 'Get ready for a hopping good time with The Buns - Hefty Hares! Join this lovable band of bunnies as they embark on a whimsical adventure through the lush, green meadows of Bunnyland.', 'inr', 'pfp', 'active', 149.00, '2024-03-24', '18:06:00'),
(15, 2, 'Assets/NFTCollection/indian-tred-thumb.jpg', '', 'Vedic Visions', '\r\nName: Vedic Visions - Ethereal Expressions\r\nJourney into the mystical realm of Vedic Visions - Ethereal Expressions, where ancient traditions merge with contemporary creativity to weave a tapestry of mesmerizing Indian artistry. ', 'inr', 'art', 'active', 149.00, '2024-03-24', '18:21:00'),
(16, 2, 'Assets/NFTCollection/PG - ancent temple 1.jpg', 'Assets/NFTCollection/PG - ancent temple.jpg', 'Sanctum of Ancients', 'Welcome to the Sanctum of Ancients - Echoes of Eternity, a sacred haven shrouded in mystery and imbued with the whispers of bygone eras. ', 'inr', 'photography', 'active', 149.00, '2024-03-24', '18:36:00'),
(17, 3, 'Assets/NFTCollection/G - Asphalt 9.jpg', 'Assets/NFTCollection/Forza Horizon 5 - background.jpg', 'CAR', 'The Cars', 'inr', 'gaming', 'active', 149.00, '2024-04-08', '12:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `nftoffers`
--

CREATE TABLE `nftoffers` (
  `offerid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `collectionid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `offerprice` decimal(10,2) NOT NULL,
  `offersupply` varchar(255) NOT NULL,
  `offerdate` date NOT NULL,
  `offertime` time NOT NULL,
  `offerenddate` date NOT NULL,
  `offerendtime` time NOT NULL,
  `offerstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nftoffers`
--

INSERT INTO `nftoffers` (`offerid`, `userid`, `collectionid`, `nftid`, `offerprice`, `offersupply`, `offerdate`, `offertime`, `offerenddate`, `offerendtime`, `offerstatus`) VALUES
(1, 2, 12, 25, 45.00, '1', '2024-03-27', '08:25:52', '0000-00-00', '00:00:00', 'pending'),
(2, 1, 0, 23, 145.00, '1', '2024-03-27', '10:22:24', '2024-03-28', '10:23:11', 'close'),
(3, 3, 11, 23, 140.00, '1', '2024-03-28', '09:39:44', '0000-00-00', '00:00:00', 'pending'),
(4, 1, 0, 24, 50.00, '1', '2024-03-28', '09:40:38', '2024-03-29', '09:40:38', 'pending'),
(5, 1, 0, 24, 51.00, '1', '2024-03-28', '09:43:01', '2024-03-29', '09:43:01', 'cancel'),
(10, 3, 1, 2, 165.00, '1', '2024-03-29', '14:01:14', '0000-00-00', '00:00:00', 'close'),
(11, 3, 1, 2, 168.00, '1', '2024-03-29', '14:01:30', '2024-03-30', '18:22:51', 'close'),
(12, 1, 1, 2, 155.00, '1', '2024-03-29', '18:31:41', '0000-00-00', '00:00:00', 'pending'),
(13, 1, 1, 2, 150.00, '1', '2024-03-29', '18:31:53', '0000-00-00', '00:00:00', 'pending'),
(14, 1, 8, 20, 230.00, '1', '2024-03-29', '18:32:29', '0000-00-00', '00:00:00', 'expired'),
(15, 3, 0, 2, 175.00, '1', '2024-03-29', '14:00:19', '2024-04-02', '00:00:00', 'expired'),
(16, 1, 0, 20, 240.00, '1', '2024-03-29', '20:04:42', '2024-04-02', '00:00:00', 'expired'),
(17, 3, 0, 2, 170.00, '1', '2024-03-29', '14:00:03', '2024-04-02', '00:00:00', 'expired'),
(18, 1, 0, 20, 236.00, '1', '2024-03-29', '20:04:27', '2024-04-02', '00:00:00', 'expired'),
(19, 3, 1, 1, 150.00, '1', '2024-04-07', '11:04:35', '0000-00-00', '00:00:00', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `nftsale`
--

CREATE TABLE `nftsale` (
  `saleid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `nftid` int(11) NOT NULL,
  `saleprice` decimal(10,2) NOT NULL,
  `salecreatedate` date NOT NULL,
  `salecreatetime` time NOT NULL,
  `saleenddate` date NOT NULL,
  `saleendtime` time NOT NULL,
  `salestatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nftsale`
--

INSERT INTO `nftsale` (`saleid`, `userid`, `nftid`, `saleprice`, `salecreatedate`, `salecreatetime`, `saleenddate`, `saleendtime`, `salestatus`) VALUES
(1, 3, 23, 139.00, '2024-03-27', '10:19:50', '2024-03-28', '10:20:00', 'close'),
(2, 3, 24, 48.00, '2024-03-28', '10:05:03', '2024-03-29', '10:06:00', 'activate'),
(3, 1, 28, 189.00, '2024-03-29', '13:39:35', '2024-03-30', '13:39:00', 'activate'),
(4, 3, 2, 169.00, '2024-03-29', '18:29:33', '2024-03-30', '18:34:00', 'activate'),
(5, 3, 2, 160.00, '2024-03-29', '18:29:55', '2024-03-30', '18:34:00', 'activate');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `transactuser` varchar(255) DEFAULT NULL,
  `creditamount` decimal(10,2) DEFAULT NULL,
  `debitamount` decimal(10,2) DEFAULT NULL,
  `transactionreason` varchar(255) DEFAULT NULL,
  `transactiondate` date NOT NULL,
  `transactiontime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionid`, `userid`, `transactuser`, `creditamount`, `debitamount`, `transactionreason`, `transactiondate`, `transactiontime`) VALUES
(1, 1, 'NFT Marketplace', 100.00, NULL, 'Joining Bonus', '2024-03-24', '11:18:00'),
(2, 1, '1', 5000.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-03-24', '11:37:09'),
(3, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Anichess Orbs of Power', '2024-03-24', '11:39:00'),
(4, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :  Anichess Orbs of Power', '2024-03-24', '11:39:00'),
(5, 1, 'NFT Marketplace', NULL, 166.88, 'Deployment charge deduction for NFT : Pawn of Water', '2024-03-24', '11:41:27'),
(6, 1, 'admin', 166.88, NULL, 'Deployment charge deduction for NFT : Pawn of Water', '2024-03-24', '11:41:27'),
(7, 1, 'NFT Marketplace', NULL, 189.28, 'Deployment charge deduction for NFT : Knight of Fire', '2024-03-24', '11:44:13'),
(8, 1, 'admin', 189.28, NULL, 'Deployment charge deduction for NFT : Knight of Fire', '2024-03-24', '11:44:13'),
(9, 1, 'NFT Marketplace', NULL, 222.88, 'Deployment charge deduction for NFT : King Of Aether', '2024-03-24', '11:46:09'),
(10, 1, 'admin', 222.88, NULL, 'Deployment charge deduction for NFT : King Of Aether', '2024-03-24', '11:46:09'),
(11, 2, 'NFT Marketplace', 100.00, NULL, 'Joining Bonus', '2024-03-24', '12:22:00'),
(12, 1, 'jay_', NULL, 1000.00, 'Fund Transfer', '2024-03-24', '12:29:54'),
(13, 2, 'admin', 1000.00, NULL, 'Fund Transfer', '2024-03-24', '12:29:54'),
(14, 2, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Doeksen Animals', '2024-03-24', '12:33:00'),
(15, 1, 'jay_', 149.00, NULL, 'Deployment charge credited for collection :  Doeksen Animals', '2024-03-24', '12:33:00'),
(16, 2, 'NFT Marketplace', NULL, 99.00, 'Deployment charge deduction for NFT : Flickerflare, the mischievous Emberwhisker.', '2024-03-24', '12:34:44'),
(17, 1, 'jay_', 99.00, NULL, 'Deployment charge deduction for NFT : Flickerflare, the mischievous Emberwhisker.', '2024-03-24', '12:34:44'),
(18, 2, 'NFT Marketplace', NULL, 166.88, 'Deployment charge deduction for NFT : Roarheart, the mighty Forest Titan', '2024-03-24', '12:36:45'),
(19, 1, 'jay_', 166.88, NULL, 'Deployment charge deduction for NFT : Roarheart, the mighty Forest Titan', '2024-03-24', '12:36:45'),
(20, 2, 'NFT Marketplace', NULL, 278.88, 'Deployment charge deduction for NFT : Whiskerwhirl, the elusive Shadow Prowler', '2024-03-24', '12:38:43'),
(21, 1, 'jay_', 278.88, NULL, 'Deployment charge deduction for NFT : Whiskerwhirl, the elusive Shadow Prowler', '2024-03-24', '12:38:43'),
(22, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   DBz - The Cosmic Blast', '2024-03-24', '13:08:00'),
(23, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :  DBz - The Cosmic Blast', '2024-03-24', '13:08:00'),
(24, 1, 'NFT Marketplace', NULL, 140.00, 'Deployment charge deduction for NFT : Black Goku', '2024-03-24', '13:09:30'),
(25, 1, 'admin', 140.00, NULL, 'Deployment charge deduction for NFT : Black Goku', '2024-03-24', '13:09:30'),
(26, 1, 'NFT Marketplace', NULL, 156.80, 'Deployment charge deduction for NFT : Prince of Power, the Saiyan Sovereign', '2024-03-24', '13:20:47'),
(27, 1, 'admin', 156.80, NULL, 'Deployment charge deduction for NFT : Prince of Power, the Saiyan Sovereign', '2024-03-24', '13:20:47'),
(28, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :    Pokémon', '2024-03-24', '13:31:00'),
(29, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :   Pokémon', '2024-03-24', '13:31:00'),
(30, 1, 'NFT Marketplace', NULL, 290.08, 'Deployment charge deduction for NFT : Aquashell - the Torrential Guardian', '2024-03-24', '13:32:32'),
(31, 1, 'admin', 290.08, NULL, 'Deployment charge deduction for NFT : Aquashell - the Torrential Guardian', '2024-03-24', '13:32:32'),
(32, 1, 'NFT Marketplace', NULL, 221.76, 'Deployment charge deduction for NFT : Emberflare - the Fiery Spirit', '2024-03-24', '13:34:49'),
(33, 1, 'admin', 221.76, NULL, 'Deployment charge deduction for NFT : Emberflare - the Fiery Spirit', '2024-03-24', '13:34:49'),
(34, 1, 'NFT Marketplace', NULL, 211.68, 'Deployment charge deduction for NFT : Echofur - the Versatile Wanderer', '2024-03-24', '13:37:53'),
(35, 1, 'admin', 211.68, NULL, 'Deployment charge deduction for NFT : Echofur - the Versatile Wanderer', '2024-03-24', '13:37:53'),
(36, 2, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Omniverse Conqueror', '2024-03-24', '13:43:00'),
(37, 1, 'jay_', 149.00, NULL, 'Deployment charge credited for collection :  Omniverse Conqueror', '2024-03-24', '13:43:00'),
(38, 1, 'jay_', NULL, 1000.00, 'Fund Transfer', '2024-03-24', '13:45:32'),
(39, 2, 'admin', 1000.00, NULL, 'Fund Transfer', '2024-03-24', '13:45:32'),
(40, 2, 'NFT Marketplace', NULL, 267.68, 'Deployment charge deduction for NFT : Inferno Fury - the Blazing Titan', '2024-03-24', '13:45:41'),
(41, 1, 'jay_', 267.68, NULL, 'Deployment charge deduction for NFT : Inferno Fury - the Blazing Titan', '2024-03-24', '13:45:41'),
(42, 2, 'NFT Marketplace', NULL, 151.20, 'Deployment charge deduction for NFT : Rampage Roar - the Unstoppable Berserker', '2024-03-24', '13:48:08'),
(43, 1, 'jay_', 151.20, NULL, 'Deployment charge deduction for NFT : Rampage Roar - the Unstoppable Berserker', '2024-03-24', '13:48:08'),
(44, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Clash Craze Chronicles', '2024-03-24', '13:51:00'),
(45, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :  Clash Craze Chronicles', '2024-03-24', '13:51:00'),
(46, 1, 'NFT Marketplace', NULL, 262.08, 'Deployment charge deduction for NFT : Grommash Bloodaxe', '2024-03-24', '13:52:17'),
(47, 1, 'admin', 262.08, NULL, 'Deployment charge deduction for NFT : Grommash Bloodaxe', '2024-03-24', '13:52:17'),
(48, 1, 'NFT Marketplace', NULL, 165.76, 'Deployment charge deduction for NFT : Merlin Spellweaver', '2024-03-24', '13:58:20'),
(49, 1, 'admin', 165.76, NULL, 'Deployment charge deduction for NFT : Merlin Spellweaver', '2024-03-24', '13:58:20'),
(50, 2, '2', 1000.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-03-24', '14:01:12'),
(51, 3, 'NFT Marketplace', 100.00, NULL, 'Joining Bonus', '2024-03-24', '14:38:00'),
(52, 3, '3', 1500.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-03-24', '14:39:15'),
(53, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Inferno Ignition', '2024-03-24', '14:42:00'),
(54, 1, 'vivek', 149.00, NULL, 'Deployment charge credited for collection :  Inferno Ignition', '2024-03-24', '14:42:00'),
(55, 3, 'NFT Marketplace', NULL, 278.88, 'Deployment charge deduction for NFT : FF - Magic', '2024-03-24', '14:45:07'),
(56, 1, 'vivek', 278.88, NULL, 'Deployment charge deduction for NFT : FF - Magic', '2024-03-24', '14:45:07'),
(57, 3, 'NFT Marketplace', NULL, 166.88, 'Deployment charge deduction for NFT : FF - Venom 3', '2024-03-24', '14:47:41'),
(58, 1, 'vivek', 166.88, NULL, 'Deployment charge deduction for NFT : FF - Venom 3', '2024-03-24', '14:47:41'),
(59, 3, 'NFT Marketplace', NULL, 267.00, 'Deployment charge deduction for NFT : FF - Woolfarahh', '2024-03-24', '14:50:01'),
(60, 1, 'vivek', 267.00, NULL, 'Deployment charge deduction for NFT : FF - Woolfarahh', '2024-03-24', '14:50:01'),
(61, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Forza Horizon 5', '2024-03-24', '15:05:00'),
(62, 1, 'vivek', 149.00, NULL, 'Deployment charge credited for collection :  Forza Horizon 5', '2024-03-24', '15:05:00'),
(63, 3, 'NFT Marketplace', NULL, 278.88, 'Deployment charge deduction for NFT : FH5 - McLaren Speedtail', '2024-03-24', '15:07:14'),
(64, 1, 'vivek', 278.88, NULL, 'Deployment charge deduction for NFT : FH5 - McLaren Speedtail', '2024-03-24', '15:07:14'),
(65, 3, 'NFT Marketplace', NULL, 263.20, 'Deployment charge deduction for NFT : FH5 - Bugatti Divo', '2024-03-24', '15:10:34'),
(66, 1, 'vivek', 263.20, NULL, 'Deployment charge deduction for NFT : FH5 - Bugatti Divo', '2024-03-24', '15:10:34'),
(67, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   PixelPulse', '2024-03-24', '15:27:00'),
(68, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :  PixelPulse', '2024-03-24', '15:27:00'),
(69, 1, 'NFT Marketplace', NULL, 49.00, 'Deployment charge deduction for NFT : Aurora', '2024-03-24', '15:28:51'),
(70, 1, 'admin', 49.00, NULL, 'Deployment charge deduction for NFT : Aurora', '2024-03-24', '15:28:51'),
(71, 3, '3', 1000.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-03-24', '16:39:50'),
(72, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Radiant Lens Revelry', '2024-03-24', '16:43:00'),
(73, 1, 'vivek', 149.00, NULL, 'Deployment charge credited for collection :  Radiant Lens Revelry', '2024-03-24', '16:43:00'),
(74, 3, 'NFT Marketplace', NULL, 89.00, 'Deployment charge deduction for NFT : Solar Bloom Spectacular', '2024-03-24', '16:44:41'),
(75, 1, 'vivek', 89.00, NULL, 'Deployment charge deduction for NFT : Solar Bloom Spectacular', '2024-03-24', '16:44:41'),
(76, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Frenly Pandas', '2024-03-24', '17:10:00'),
(77, 1, 'vivek', 149.00, NULL, 'Deployment charge credited for collection :  Frenly Pandas', '2024-03-24', '17:10:00'),
(78, 3, 'NFT Marketplace', NULL, 156.80, 'Deployment charge deduction for NFT : Frenly Pandas 001', '2024-03-24', '17:10:55'),
(79, 1, 'vivek', 156.80, NULL, 'Deployment charge deduction for NFT : Frenly Pandas 001', '2024-03-24', '17:10:55'),
(80, 3, 'NFT Marketplace', NULL, 49.00, 'Deployment charge deduction for NFT : Frenly Pandas 002', '2024-03-24', '17:13:25'),
(81, 1, 'vivek', 49.00, NULL, 'Deployment charge deduction for NFT : Frenly Pandas 002', '2024-03-24', '17:13:25'),
(82, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Pudgy Rods', '2024-03-24', '17:19:00'),
(83, 1, 'vivek', 149.00, NULL, 'Deployment charge credited for collection :  Pudgy Rods', '2024-03-24', '17:19:00'),
(84, 3, 'NFT Marketplace', NULL, 96.00, 'Deployment charge deduction for NFT : Pudgy Rod 001', '2024-03-24', '17:20:35'),
(85, 1, 'vivek', 96.00, NULL, 'Deployment charge deduction for NFT : Pudgy Rod 001', '2024-03-24', '17:20:35'),
(86, 1, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Asphalt 9', '2024-03-24', '17:30:00'),
(87, 1, 'admin', 149.00, NULL, 'Deployment charge credited for collection :  Asphalt 9', '2024-03-24', '17:30:00'),
(88, 1, 'NFT Marketplace', NULL, 334.88, 'Deployment charge deduction for NFT : A9 - Lamborghini', '2024-03-24', '17:40:59'),
(89, 1, 'admin', 334.88, NULL, 'Deployment charge deduction for NFT : A9 - Lamborghini', '2024-03-24', '17:40:59'),
(90, 1, 'NFT Marketplace', NULL, 390.88, 'Deployment charge deduction for NFT : A9 - Lamborghini Veneno', '2024-03-24', '17:44:57'),
(91, 1, 'admin', 390.88, NULL, 'Deployment charge deduction for NFT : A9 - Lamborghini Veneno', '2024-03-24', '17:44:57'),
(92, 2, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   The Buns - Hefty Hares', '2024-03-24', '18:06:00'),
(93, 1, 'jay_', 149.00, NULL, 'Deployment charge credited for collection :  The Buns - Hefty Hares', '2024-03-24', '18:06:00'),
(94, 2, 'NFT Marketplace', NULL, 49.00, 'Deployment charge deduction for NFT : The BUN 001', '2024-03-24', '18:10:34'),
(95, 1, 'jay_', 49.00, NULL, 'Deployment charge deduction for NFT : The BUN 001', '2024-03-24', '18:10:34'),
(96, 2, 'NFT Marketplace', NULL, 58.00, 'Deployment charge deduction for NFT : The Bun 002', '2024-03-24', '18:17:13'),
(97, 1, 'jay_', 58.00, NULL, 'Deployment charge deduction for NFT : The Bun 002', '2024-03-24', '18:17:13'),
(98, 2, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Vedic Visions', '2024-03-24', '18:21:00'),
(99, 1, 'jay_', 149.00, NULL, 'Deployment charge credited for collection :  Vedic Visions', '2024-03-24', '18:21:00'),
(100, 2, 'NFT Marketplace', NULL, 166.88, 'Deployment charge deduction for NFT :  Opulent Plumage - The Peacocks Pride', '2024-03-24', '18:24:41'),
(101, 1, 'jay_', 166.88, NULL, 'Deployment charge deduction for NFT :  Opulent Plumage - The Peacocks Pride', '2024-03-24', '18:24:41'),
(102, 2, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   Sanctum of Ancients - Echoes of Eternity', '2024-03-24', '18:36:00'),
(103, 1, 'jay_', 149.00, NULL, 'Deployment charge credited for collection :  Sanctum of Ancients - Echoes of Eternity', '2024-03-24', '18:36:00'),
(104, 2, 'NFT Marketplace', NULL, 277.76, 'Deployment charge deduction for NFT : Sanctum of Ancients 001', '2024-03-24', '18:37:49'),
(105, 1, 'jay_', 277.76, NULL, 'Deployment charge deduction for NFT : Sanctum of Ancients 001', '2024-03-24', '18:37:49'),
(106, 2, 'NFT Marketplace', NULL, 166.88, 'Deployment charge deduction for NFT : Sanctum of Ancients 002', '2024-03-24', '18:39:56'),
(107, 1, 'jay_', 166.88, NULL, 'Deployment charge deduction for NFT : Sanctum of Ancients 002', '2024-03-24', '18:39:56'),
(108, 2, '2', 100.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-03-27', '08:50:11'),
(109, 1, '3', NULL, 147.90, 'Purchasing charge deduction for NFT : Frenly Pandas 001 from Frenly Pandas122', '2024-03-27', '10:25:08'),
(110, 3, '1', 145.00, NULL, 'Selling Amount credited into wallet for NFT : Frenly Pandas 001 from Frenly Pandas122', '2024-03-27', '10:25:08'),
(111, 1, '1', 2.90, NULL, 'Transaction charge credited into wallet for NFT : Frenly Pandas 001 from Frenly Pandas122', '2024-03-27', '10:25:08'),
(112, 3, '1', NULL, 171.36, 'Purchasing charge deduction for NFT : Knight of Fire from Anichess Orbs of Power', '2024-03-29', '18:27:19'),
(113, 1, '3', 168.00, NULL, 'Selling Amount credited into wallet for NFT : Knight of Fire from Anichess Orbs of Power', '2024-03-29', '18:27:19'),
(114, 1, '3', 3.36, NULL, 'Transaction charge credited into wallet for NFT : Knight of Fire from Anichess Orbs of Power', '2024-03-29', '18:27:19'),
(115, 1, 'vivek', NULL, 100.00, 'Fund Transfer', '2024-04-07', '10:52:58'),
(116, 3, 'admin', 100.00, NULL, 'Fund Transfer', '2024-04-07', '10:52:58'),
(117, 3, '3', 100.00, 0.00, 'Funds have been successfully added to your wallet using NETBANKING.', '2024-04-08', '12:42:40'),
(118, 3, 'NFT Marketplace', NULL, 149.00, 'Deployment charge deduction for collection :   CAR', '2024-04-08', '12:48:00'),
(119, 1, 'Vivek', 149.00, NULL, 'Deployment charge credited for collection :  CAR', '2024-04-08', '12:48:00'),
(120, 3, 'NFT Marketplace', NULL, 89.00, 'Deployment charge deduction for NFT : Car 1', '2024-04-08', '12:50:32'),
(121, 1, 'Vivek', 89.00, NULL, 'Deployment charge deduction for NFT : Car 1', '2024-04-08', '12:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `walletPassword` varchar(255) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `userid`, `walletPassword`, `balance`) VALUES
(1, 1, '$2y$10$86/EoShvOKUvKxs90hgDrOk4Zp0y6sphJmHyeZgDl.MXCpafjhHbC', 8062.06),
(2, 2, '$2y$10$l73ABNFia7klMYBDz9.NhOp8gTq9H9Eka87OhJFk9qxKgfne4yVj.', 772.84),
(3, 3, '$2y$10$vHeVb4jRmGxFZ/i4Nt1PWeT/rm..mIJtEA8GRLsRKX.SZt.j9QheG', 145.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityid`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`articleid`);

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`auctionid`);

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`biddingid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faqid`),
  ADD UNIQUE KEY `faqimage` (`faqimage`),
  ADD UNIQUE KEY `faqtitle` (`faqtitle`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginhistory`
--
ALTER TABLE `loginhistory`
  ADD PRIMARY KEY (`loginid`);

--
-- Indexes for table `nft`
--
ALTER TABLE `nft`
  ADD PRIMARY KEY (`nftid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `collectionid` (`collectionid`);

--
-- Indexes for table `nftactivity`
--
ALTER TABLE `nftactivity`
  ADD PRIMARY KEY (`transferid`);

--
-- Indexes for table `nftcollected`
--
ALTER TABLE `nftcollected`
  ADD PRIMARY KEY (`collectid`);

--
-- Indexes for table `nftcollection`
--
ALTER TABLE `nftcollection`
  ADD PRIMARY KEY (`collectionid`);

--
-- Indexes for table `nftoffers`
--
ALTER TABLE `nftoffers`
  ADD PRIMARY KEY (`offerid`);

--
-- Indexes for table `nftsale`
--
ALTER TABLE `nftsale`
  ADD PRIMARY KEY (`saleid`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `auctionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `biddingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faqid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loginhistory`
--
ALTER TABLE `loginhistory`
  MODIFY `loginid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `nft`
--
ALTER TABLE `nft`
  MODIFY `nftid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `nftactivity`
--
ALTER TABLE `nftactivity`
  MODIFY `transferid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nftcollected`
--
ALTER TABLE `nftcollected`
  MODIFY `collectid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nftcollection`
--
ALTER TABLE `nftcollection`
  MODIFY `collectionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nftoffers`
--
ALTER TABLE `nftoffers`
  MODIFY `offerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `nftsale`
--
ALTER TABLE `nftsale`
  MODIFY `saleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nft`
--
ALTER TABLE `nft`
  ADD CONSTRAINT `nft_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `auth` (`id`),
  ADD CONSTRAINT `nft_ibfk_2` FOREIGN KEY (`collectionid`) REFERENCES `nftcollection` (`collectionid`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `auth` (`id`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `auth` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
