-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 11:22 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minda_doctracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `courier`
--

CREATE TABLE `courier` (
  `id` bigint(20) NOT NULL,
  `courier_abbv` varchar(255) DEFAULT NULL,
  `courier_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courier`
--

INSERT INTO `courier` (`id`, `courier_abbv`, `courier_desc`) VALUES
(1, 'LBC', 'LBCorporation'),
(2, 'E-Mail', 'Electronic Mail'),
(3, 'FAX', 'Electronic FAX'),
(5, NULL, 'JRS Express'),
(6, NULL, 'Ninja Van');

-- --------------------------------------------------------

--
-- Table structure for table `externals`
--

CREATE TABLE `externals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `briefer_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `doc_receive` date DEFAULT NULL,
  `doc_date_ff` date DEFAULT NULL,
  `day_count` int(11) NOT NULL DEFAULT 0,
  `signatory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sig_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `n_copy` int(11) NOT NULL DEFAULT 0,
  `n_pages` int(11) NOT NULL DEFAULT 0,
  `uploadby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retdoc` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `externals`
--

INSERT INTO `externals` (`id`, `doctitle`, `agency`, `briefer_number`, `description`, `barcode`, `sender`, `type`, `image`, `status`, `doc_receive`, `doc_date_ff`, `day_count`, `signatory`, `sendername`, `sig_email`, `n_copy`, `n_pages`, `uploadby`, `retdoc`, `created_at`, `updated_at`) VALUES
(1, 'advisory', 'DBM-IX', NULL, 'Copy of the Committee on Devolution Advisory No. 2021-001 dated November 29, 2021, entitled, \"Advisory for the National Government Agencies to Coordinate with the Local Government Units Regarding the Details of their Respective Devolution Transition Plans.\"', 'MINDA-202106649', 'RECORDS', 'Operation', 'noimage.jpg', 'on-going', '2021-12-15', '2022-02-20', 0, 'OED', 'xxxx', 'ivymae.arnoco@minda.gov.ph', 1, 10, 'CAMAGONG, MA. CRISTINA S', 1, '2021-12-13 19:26:22', '2021-12-13 19:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `external_departments`
--

CREATE TABLE `external_departments` (
  `id` bigint(20) NOT NULL,
  `ff_id` bigint(20) NOT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `stat` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `external_departments`
--

INSERT INTO `external_departments` (`id`, `ff_id`, `dept`, `stat`) VALUES
(1, 1, 'RECORDS', 'on-going'),
(2, 1, 'OED', 'pending'),
(3, 1, 'RECORDS', 'on-going'),
(4, 1, 'RECORDS', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `external_files`
--

CREATE TABLE `external_files` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `img_file` varchar(255) DEFAULT NULL,
  `doc_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `external_files`
--

INSERT INTO `external_files` (`id`, `ref_id`, `img_file`, `doc_title`) VALUES
(1, 1, '4e5e9a8e4d2b0903fd1456acc1973588.pdf', 'advisory'),
(2, 1, '9005a7a398db0300c0cd4483780972a2.pdf', 'advisory'),
(3, 1, '1f8d55e31b2597650283fdd2926b7add.pdf', 'advisory');

-- --------------------------------------------------------

--
-- Table structure for table `external_history`
--

CREATE TABLE `external_history` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_forwared` varchar(255) DEFAULT NULL,
  `date_ff` date DEFAULT NULL,
  `days_count` int(11) NOT NULL DEFAULT 0,
  `department` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `classification` int(11) DEFAULT 0,
  `confi_name` varchar(255) DEFAULT NULL,
  `actioned` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `external_history`
--

INSERT INTO `external_history` (`id`, `ref_id`, `remarks`, `date_forwared`, `date_ff`, `days_count`, `department`, `stat`, `destination`, `classification`, `confi_name`, `actioned`) VALUES
(1, 1, 'Document Tracking Started', 'December 14, 2021 @ 11:26:22 am', '2021-12-14', 0, 'RECORDS', 'on-going', 'RECORDS', 4, 'JUALO, MARILYN P.', 1),
(2, 1, 'for instruction of Usec. Lopoz', 'December 14, 2021 @ 11:29:43 am', '2021-12-14', 87, 'OED', 'pending', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwared to OED', 0, NULL, 0),
(3, 1, ' *for information*, <br> *for approval/signature* <br>', 'February 20, 2022 @ 10:33:54 pm', '2022-02-20', 68, 'RECORDS', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwared to RECORDS', 0, NULL, 1),
(4, 1, ' *for information*, <br> *for review and evaluation* <br>', 'February 20, 2022 @ 10:39:48 pm', '2022-02-20', 19, 'RECORDS', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwared to RECORDS', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internals`
--

CREATE TABLE `internals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `briefer_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signatory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `doc_receive` date DEFAULT NULL,
  `doc_date_ff` date DEFAULT NULL,
  `day_count` int(11) NOT NULL DEFAULT 0,
  `retdoc` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internals`
--

INSERT INTO `internals` (`id`, `agency`, `briefer_number`, `doctitle`, `description`, `barcode`, `signatory`, `sender`, `type`, `image`, `status`, `doc_receive`, `doc_date_ff`, `day_count`, `retdoc`, `created_at`, `updated_at`) VALUES
(1, 'PPPDO', '2111-00387', 'Letters', 'Postponement for the conduct of the capacity building workshop on the Pre-establishment of an AEZ in Lanao del Sur on 13-14 December 2021, SEDA Centrio, Cagayan de Oro City', 'MINDA-202106642', 'LABOR, ANA MARIE A', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'on-going', '2021-11-30', '2022-02-19', 80, 0, '2021-11-30 19:23:23', '2021-11-30 19:23:23'),
(2, 'PPPDO', '2111-00387', 'Letters', 'Postponement for the conduct of the capacity building workshop on the Pre-establishment of an AEZ in Lanao del Sur on 13-14 December 2021, SEDA Centrio, Cagayan de Oro City', 'MINDA-202106642', 'LABOR, ANA MARIE A', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'pending', '2021-11-30', '2021-12-01', 100, 0, '2021-11-30 19:25:54', '2021-11-30 19:25:54'),
(3, 'PDD', '2111-00370', 'Letter', 'Request letter re visit to Economic Zone in General Santos City on November 17, 2021', 'MINDA-202106460', 'LABOR, ANA MARIE A', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'on-going', '2021-11-15', '2022-02-20', 80, 0, '2021-12-01 22:12:44', '2021-12-01 22:12:44'),
(4, 'PPPDO', '222222', 'Travel documents', 'Local Travel Order no. TO-OACPM-2021-11-731:  In the areas of Lanao del Sur, Lanao del Norte, Misamis Occidental, Misamis Oriental, Bukidnon, North Cotabato and Davao City on December 1-4, 2021 (Olie B. Dagala and Nathaniel Fabila)', 'MINDA-202106643', 'LEGASPI, OLIVER V', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'complete', '2021-12-14', '2021-12-14', 0, 0, '2021-12-13 18:11:05', '2021-12-13 18:11:05'),
(5, 'AMO-WM', '33333', 'Travel documents', 'Local Travel Order no. TO-OACPM-2021-11-727 and Itinerary of Travel:  Maluso, Basilan Province on November 28-30, 2021 (Jean Paul C. Tolentino)', 'MINDA-202106644', 'TOLENTINO, JEAN PAUL', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'complete', '2021-12-14', '2021-12-14', 0, 0, '2021-12-13 19:04:13', '2021-12-13 19:04:13'),
(6, 'KMD', '343455345', 'Letter Sample', 'Tracking Sample', '234242424234234', 'TEJANO, RAYMOND R', 'RECORDS', 'Internal Documents', 'noimage.jpg', 'on-going', '2022-01-10', '2022-01-10', 0, 1, '2022-01-09 22:35:39', '2022-01-09 22:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `internal_departments`
--

CREATE TABLE `internal_departments` (
  `id` bigint(20) NOT NULL,
  `ff_id` bigint(20) NOT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `stat` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `internal_departments`
--

INSERT INTO `internal_departments` (`id`, `ff_id`, `dept`, `stat`) VALUES
(1, 1, 'RECORDS', 'on-going'),
(2, 2, 'RECORDS', 'pending'),
(3, 3, 'RECORDS', 'on-going'),
(4, 4, 'RECORDS', 'on-going'),
(5, 4, 'OED', 'on-going'),
(6, 4, 'RECORDS', 'on-going'),
(7, 4, 'IRD', 'complete'),
(8, 5, 'RECORDS', 'on-going'),
(9, 5, 'OED', 'on-going'),
(10, 5, 'AMO-WM', 'complete'),
(11, 6, 'RECORDS', 'on-going'),
(12, 6, 'KMD', 'on-going'),
(13, 6, 'RECORDS', 'pending'),
(14, 1, 'AD', 'on-going'),
(15, 1, 'AD', 'on-going'),
(16, 1, 'AD', 'on-going'),
(17, 1, 'AD', 'on-going'),
(18, 1, 'AD', 'on-going'),
(19, 1, 'AD', 'on-going'),
(20, 1, 'AD', 'on-going'),
(21, 1, 'AD', 'on-going'),
(22, 1, 'AD', 'on-going'),
(23, 1, 'AD', 'on-going'),
(24, 1, 'AD', 'on-going'),
(25, 1, 'AD', 'on-going'),
(26, 1, 'AD', 'pending'),
(27, 3, 'RECORDS', 'on-going'),
(28, 3, 'RECORDS', 'on-going'),
(29, 3, 'OC', 'pending'),
(30, 3, 'OC', 'pending'),
(31, 3, 'OC', 'pending'),
(32, 3, 'OC', 'pending'),
(33, 3, 'OC', 'pending'),
(34, 3, 'OC', 'pending'),
(35, 3, 'OC', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `internal_files`
--

CREATE TABLE `internal_files` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `img_file` varchar(255) DEFAULT NULL,
  `doc_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `internal_files`
--

INSERT INTO `internal_files` (`id`, `ref_id`, `img_file`, `doc_title`) VALUES
(1, 3, 'e09ebcbbd6adc0e7e852139ab3d9fcbb.pdf', 'Letter'),
(2, 3, 'b03a7f12be14b2f145ccf9bd0acb5b77.pdf', 'Letter'),
(3, 3, '139b8d542fcc42ab9037f782faa6c1c9.pdf', 'Letter'),
(4, 3, '23dd6c61f42769b19c2fb482e3451105.pdf', 'Letter'),
(5, 1, '3593d6251ede7d52f49bbc5742176e15.pdf', 'Letters'),
(6, 1, '12f2f7c97e28b6b77ebe99fcd81ec24f.pdf', 'Letters'),
(7, 1, 'cc9fc245a3880e6d31e4e64e66ad65aa.pdf', 'Letters'),
(8, 1, '046536ef3425afc8d4b4f1d7458eb969.pdf', 'Letters'),
(9, 1, '8a6253f15292c3db3afec04cc710e7cd.pdf', 'Letters'),
(10, 1, 'f6086279fe2c31630a0617e57afaad90.pdf', 'Letters'),
(11, 1, '89ccaf29188e669c3f08ebe9d3161891.pdf', 'Letters'),
(12, 1, '921e08810156b07f875b6b24ce0eda6f.pdf', 'Letters'),
(13, 4, '94e2f9967e4b628c6e1cce508b2a2293.pdf', 'Travel documents'),
(14, 4, '1e1a762148b10c6809c865ca84e2e957.pdf', 'Travel documents'),
(15, 5, '548a7fc794b640c5675eda9e854c3330.pdf', 'Travel documents'),
(16, 5, '4e19d4aea42b1a8a248654d2d4d27fe2.pdf', 'Travel documents');

-- --------------------------------------------------------

--
-- Table structure for table `internal_history`
--

CREATE TABLE `internal_history` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_ff` date DEFAULT NULL,
  `date_forwared` varchar(255) DEFAULT NULL,
  `days_count` int(11) NOT NULL DEFAULT 0,
  `department` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `classification` int(11) DEFAULT 0,
  `confi_name` varchar(255) DEFAULT NULL,
  `actioned` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `internal_history`
--

INSERT INTO `internal_history` (`id`, `ref_id`, `remarks`, `date_ff`, `date_forwared`, `days_count`, `department`, `stat`, `destination`, `classification`, `confi_name`, `actioned`) VALUES
(1, 1, 'Document Tracking Started', '2021-12-01', 'December 1, 2021 @ 11:23:23 am', 80, 'RECORDS', 'on-going', 'RECORDS', 2, 'ALONTO, HONEY JADE V', 1),
(2, 2, 'Document Tracking Started', '2021-12-01', 'December 1, 2021 @ 11:25:54 am', 100, 'RECORDS', 'pending', 'RECORDS', 2, NULL, 1),
(3, 3, 'Document Tracking Started', '2021-12-02', 'December 2, 2021 @ 2:12:44 pm', 80, 'RECORDS', 'on-going', 'RECORDS', 2, NULL, 1),
(4, 4, 'Document Tracking Started', '2021-12-14', 'December 14, 2021 @ 10:11:05 am', 0, 'RECORDS', 'on-going', 'RECORDS', 2, 'LOPOZ', 1),
(5, 4, ' *for approval/signature* <br>', '2021-12-14', 'December 14, 2021 @ 10:15:40 am', 0, 'OED', 'on-going', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwarded to OED', 2, 'LOPOZ', 1),
(6, 4, '*for appropriate action*, <br>cc OED', '2021-12-14', 'December 14, 2021 @ 10:36:18 am', 0, 'RECORDS', 'on-going', 'JUALO, MARILYN P. from OED Forwarded to RECORDS', 2, 'LOPOZ', 1),
(7, 4, 'completed on December 14, 2021 @ 02:45:12', '2021-12-14', 'December 14, 2021 @ 10:39:03 am', 0, 'IRD', 'complete', 'IRD complete the tracking', 2, 'LOPOZ', 1),
(8, 5, 'Document Tracking Started', '2021-12-14', 'December 14, 2021 @ 11:04:13 am', 0, 'RECORDS', 'on-going', 'RECORDS', 3, NULL, 1),
(9, 5, ' *for approval/signature* <br>', '2021-12-14', 'December 14, 2021 @ 11:06:42 am', 0, 'OED', 'on-going', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwarded to OED', 3, NULL, 0),
(10, 5, 'completed on December 14, 2021 @ 03:10:23', '2021-12-14', 'December 14, 2021 @ 11:07:59 am', 0, 'AMO-WM', 'complete', 'AMO-WM complete the tracking', 3, NULL, 1),
(11, 6, 'Document Tracking Started', '2022-01-10', 'January 10, 2022 @ 2:35:39 pm', 0, 'RECORDS', 'on-going', 'RECORDS', 3, NULL, 1),
(12, 6, '*for appropriate action*, <br> *for review and evaluation* <br>', '2022-01-10', 'January 10, 2022 @ 2:36:40 pm', 0, 'KMD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to KMD', 3, NULL, 1),
(13, 6, ' *for information*, <br>Testiing compkete', '2022-01-10', 'January 10, 2022 @ 2:38:48 pm', 60, 'RECORDS', 'pending', 'TEJANO, RAYMOND R from KMD Forwarded to RECORDS', 3, NULL, 1),
(14, 1, 'Ma\'am Ces, testing lang po', '2022-02-19', 'February 19, 2022 @ 11:42:26 am', 0, 'AD', 'on-going', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(15, 1, 'testing', '2022-02-19', 'February 19, 2022 @ 12:00:15 pm', 0, 'AD', 'on-going', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(16, 1, 'testing lang maam', '2022-02-19', 'February 19, 2022 @ 12:14:13 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(17, 1, 'try lang maam ces', '2022-02-19', 'February 19, 2022 @ 12:14:56 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(18, 1, 'try lang maam ces', '2022-02-19', 'February 19, 2022 @ 12:14:58 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(19, 1, 'test', '2022-02-19', 'February 19, 2022 @ 12:46:20 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(20, 1, 'rreet', '2022-02-19', 'February 19, 2022 @ 12:54:29 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(21, 1, 'try lang maam ces', '2022-02-19', 'February 19, 2022 @ 12:56:57 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(22, 1, 'test', '2022-02-19', 'February 19, 2022 @ 1:00:39 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(23, 1, 'Ok na ang email maam....na usab ang config sa email sender sa no-reply@minda.gov.ph', '2022-02-19', 'February 19, 2022 @ 1:22:12 pm', 0, 'AD', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(24, 1, 'test only', '2022-02-19', 'February 19, 2022 @ 1:45:55 pm', 0, 'AD', 'on-going', 'CAMAGONG, MA. CRISTINA S from RECORDS Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(25, 1, '*for appropriate action*, <br> *for information*, <br> *for guidance*, <br> *for reference*, <br> *for review and evaluation* <br> *for approval/signature* <br>MMMVMVMVVMVMMV', '2022-02-19', 'February 19, 2022 @ 2:32:43 pm', 0, 'AD', 'on-going', 'TRIÑO, CECILIA D from AD Forwarded to AD', 2, 'ALONTO, HONEY JADE V', 1),
(26, 1, 'MVMVMVMVM', '2022-02-19', 'February 19, 2022 @ 2:53:29 pm', 20, 'AD', 'pending', 'TRIÑO, CECILIA D from AD Forwarded to AD', 2, NULL, 0),
(28, 3, ' *for information*, <br> *for approval/signature* <br>', '2022-02-20', 'February 20, 2022 @ 6:02:27 pm', 0, 'RECORDS', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to RECORDS', 2, NULL, 1),
(27, 3, '', '2022-02-20', 'February 20, 2022 @ 6:00:39 pm', 80, 'RECORDS', 'on-going', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to RECORDS', 2, NULL, 1),
(29, 3, '', '2022-02-20', 'February 20, 2022 @ 6:10:09 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(30, 3, ' *for review and evaluation* <br> *for approval/signature* <br>', '2022-02-20', 'February 20, 2022 @ 6:10:23 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(31, 3, '', '2022-02-20', 'February 20, 2022 @ 6:11:34 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(32, 3, '', '2022-02-20', 'February 20, 2022 @ 6:12:14 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(33, 3, '', '2022-02-20', 'February 20, 2022 @ 6:12:42 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(34, 3, ' *for information*, <br> *for approval/signature* <br>', '2022-02-20', 'February 20, 2022 @ 10:14:34 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0),
(35, 3, ' *for information*, <br> *for approval/signature* <br>', '2022-02-20', 'February 20, 2022 @ 10:18:50 pm', 19, 'OC', 'pending', 'RICO, JOLITO DESPOSADO from RECORDS Forwarded to OC', 2, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` bigint(20) NOT NULL,
  `doc_lib_abbrv` varchar(255) DEFAULT NULL,
  `doc_full_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `doc_lib_abbrv`, `doc_full_desc`) VALUES
(1, NULL, 'Document');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2020_09_24_100348_create_incomings_table', 2),
(7, '2020_09_24_100408_create_outgoings_table', 2),
(8, '2021_03_03_232946_create_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `outgoings`
--

CREATE TABLE `outgoings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `briefer_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signatory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sendto_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `doc_receive` date DEFAULT NULL,
  `doc_date_ff` date DEFAULT NULL,
  `day_count` int(11) NOT NULL DEFAULT 0,
  `retdoc` int(11) NOT NULL DEFAULT 0,
  `releasemode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outgoings`
--

INSERT INTO `outgoings` (`id`, `agency`, `briefer_number`, `doctitle`, `description`, `barcode`, `signatory`, `sender`, `sendto`, `sendto_email`, `type`, `image`, `status`, `doc_receive`, `doc_date_ff`, `day_count`, `retdoc`, `releasemode`, `created_at`, `updated_at`) VALUES
(1, 'gdsgsdgfds', '45646456', 'Document', 'dsfdzvzxdvzxd', '345345345345', 'dgfcfhfdg fdg', 'RECORDS', 'dfsdfdsf', 'jolito.rico@minda.gov.ph', 'Outgoing Documents', 'noimage.jpg', 'pending', '2022-02-21', '2022-02-20', 19, 0, 'FAX', '2022-02-20 06:41:23', '2022-02-20 06:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_departments`
--

CREATE TABLE `outgoing_departments` (
  `id` bigint(20) NOT NULL,
  `ff_id` bigint(20) NOT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `stat` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `outgoing_departments`
--

INSERT INTO `outgoing_departments` (`id`, `ff_id`, `dept`, `stat`) VALUES
(1, 1, 'RECORDS', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_files`
--

CREATE TABLE `outgoing_files` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `img_file` varchar(255) DEFAULT NULL,
  `doc_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_history`
--

CREATE TABLE `outgoing_history` (
  `id` bigint(20) NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_ff` date DEFAULT NULL,
  `date_forwared` varchar(255) DEFAULT NULL,
  `days_count` int(11) NOT NULL DEFAULT 0,
  `department` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `classification` int(11) DEFAULT 0,
  `confi_name` varchar(255) DEFAULT NULL,
  `actioned` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `outgoing_history`
--

INSERT INTO `outgoing_history` (`id`, `ref_id`, `remarks`, `date_ff`, `date_forwared`, `days_count`, `department`, `stat`, `destination`, `classification`, `confi_name`, `actioned`) VALUES
(1, 1, 'Document Tracking Started', '2022-02-20', 'February 20, 2022 @ 10:41:23 pm', 19, 'RECORDS', 'pending', 'RECORDS', 3, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pap_codes`
--

CREATE TABLE `pap_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respocenter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pap_codes`
--

INSERT INTO `pap_codes` (`id`, `division`, `respocenter`, `created_at`, `updated_at`) VALUES
(1, 'OC', 'Office of the Chairman', NULL, NULL),
(2, 'PPPDO', 'Policy Planning and Project Development Office', NULL, NULL),
(3, 'PPD', 'Planning and Research Division', NULL, NULL),
(4, 'PFD', 'Policy Formulation Division', NULL, NULL),
(5, 'PDD', 'Project Development Division', NULL, NULL),
(6, 'KMD', 'Knowledge Management Division', NULL, NULL),
(7, 'IPPA', 'Investment Promotion and Public Affairs', NULL, NULL),
(8, 'IPD', 'Investment Promotion Division', NULL, NULL),
(9, 'IRD', 'Internationals Relations Division', NULL, NULL),
(10, 'PuRD', 'Public Relations Division', NULL, NULL),
(11, 'OFAS', 'Office of Finance and Administrative Services', NULL, NULL),
(12, 'FD', 'Finance Division', NULL, NULL),
(13, 'AD', 'Administrative Division', NULL, NULL),
(14, 'OPMAC', 'Office for Project Management and Area Concerns', NULL, NULL),
(15, 'AMO-Western Mindanao', 'AMO-Western Mindanao', NULL, NULL),
(16, 'AMO-Northern Mindanao', 'AMO-Northern Mindanao', NULL, NULL),
(17, 'AMO-Central Mindanao', 'AMO-Central Mindanao', NULL, NULL),
(18, 'AMO-Northeastern Mindanao', 'AMO-Northeastern Mindanao', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_counts`
--

CREATE TABLE `project_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `project_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_counts`
--

INSERT INTO `project_counts` (`id`, `year`, `project_count`, `created_at`, `updated_at`) VALUES
(1, 2021, 4, '2021-12-01 22:12:44', '2021-12-13 19:26:22'),
(2, 2022, 1, '2022-01-09 22:35:39', '2022-01-09 22:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_number`
--

CREATE TABLE `tracking_number` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `tracking_series` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docdescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracking_number`
--

INSERT INTO `tracking_number` (`id`, `ref_id`, `tracking_series`, `barcode`, `doctitle`, `docdescription`, `doctype`) VALUES
(1, 3, 'MinDA-2021-00001', 'MINDA-202106460', 'Letter', 'Request letter re visit to Economic Zone in General Santos City on November 17, 2021', 'Internal'),
(2, 4, 'MinDA-2021-00002', 'MINDA-202106643', 'Travel documents', 'Local Travel Order no. TO-OACPM-2021-11-731:  In the areas of Lanao del Sur, Lanao del Norte, Misamis Occidental, Misamis Oriental, Bukidnon, North Cotabato and Davao City on December 1-4, 2021 (Olie B. Dagala and Nathaniel Fabila)', 'Internal'),
(3, 5, 'MinDA-2021-00003', 'MINDA-202106644', 'Travel documents', 'Local Travel Order no. TO-OACPM-2021-11-727 and Itinerary of Travel:  Maluso, Basilan Province on November 28-30, 2021 (Jean Paul C. Tolentino)', 'Internal'),
(4, 1, 'MinDA-2021-00004', 'MINDA-202106649', 'advisory', 'Copy of the Committee on Devolution Advisory No. 2021-001 dated November 29, 2021, entitled, \"Advisory for the National Government Agencies to Coordinate with the Local Government Units Regarding the Details of their Respective Devolution Transition Plans', 'External'),
(5, 6, 'MinDA-2022-00001', '234242424234234', 'Letter Sample', 'Tracking Sample', 'Internal');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_level` int(11) NOT NULL DEFAULT 1,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NoImage.png',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `f_name`, `email`, `email_verified_at`, `password`, `position`, `division`, `access_level`, `profile_img`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'adatukan', 'DATUKAN, AMHED JEOFFREY J.', 'amhed.datukan@minda.gov.ph', NULL, '$2y$10$BHqjhq95lFpUQI.5s.9f.uHoXdXWbsDkYO8X4a73athTcxVEujQGa', 'DMO lll', 'IRD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(2, 'egilayo', 'GILAYO, EAMARIE  M.', 'eamarie.gilayo@minda.gov.ph', NULL, '$2y$10$XFupJRnYDtelChZ7GvbLKel/du0UIpjw38XpJIWHaMCOoWRbc4c8C', 'DMO lll', 'IRD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(3, 'agotera', 'GOTERA, ANNABELLE ROSALES', 'bellerosales.gotera@minda.gov.ph', NULL, '$2y$10$Rm0SB6wKqMjdoreUwl27..va.iuLv7DW2LAMpd9uRNePqXW9A0V6.', 'DMO I', 'IRD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(4, 'jmiral', 'MIRAL, JONATHAN C.', 'jon.miral@minda.gov.ph', NULL, '$2y$10$egnyj6oCc9y8rz2brNXnSu7MTxQMEivzQN8WOb2LpCZKrczAufuTC', 'DMO V', 'IRD', 2, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(5, 'ssales', 'SALES, SYLVESTER C.', 'sylvester.sales@minda.gov.ph', NULL, '$2y$10$Y3hh.ycROWFNtAz5kVT4Iuh34RyNaWegigy4J3CO1mU/uApxHRAjq', 'DMO lV', 'IRD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(6, 'nyago', 'YAGO, NIñA R.', 'nina.yago@minda.gov.ph', NULL, '$2y$10$QmTC/Lvj4xIG.TjvSixTe.JYgZs5T3sMGzcE7vFfpLltfQXH.TC2q', 'DMO ll', 'IRD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(7, 'wjimeno', 'JIMENO, WARDINO D.', NULL, NULL, '$2y$10$tI2qM3kXmD/nQe8HIMPReusYId/Qb20cz/uV6kNRbtcduxAI69DaK', 'Admin Aide III', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(8, 'rparillo', 'PARILLO, ROSELYN P.', NULL, NULL, '$2y$10$PlfMYO0je7xmrpQyZdVmPeMUWwHHlXI8OsQ6LgqJsPDeE.Ozp533m', 'Exec Assistant V', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(9, 'epinol', 'PIñOL, EMMANUEL F.', NULL, NULL, '$2y$10$Y9Kp64Wv6GW.Diyc6Qt2Q.hu1BCF83Agwc7O4CRCC3O0LF7UH4vgi', 'Chairman', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(10, 'fsolin', 'SOLIN III, FRANCISCO C.', NULL, NULL, '$2y$10$V8/4A5Skg2y26/hQHV8Npe/6UQnCuUDWlJyutjlD7a8bCdTQpFrCK', 'Admin Aide V', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(11, 'fanecito', 'SOLIS, FERNANDO ANECITO T.', NULL, NULL, '$2y$10$lSpWTp55onTQDXm6bVOV7ePn7hqeuckAHalhH0eh.QndR8rGuOpdC', 'Exec Assistant II', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(12, 'rdatukon', 'DATUKON, RANIZZA', 'ranizza.datukon@minda.gov.ph', NULL, '$2y$10$VrsxOBZzi1odbiRkwZEXFe1oJEyzwgyl4eZIZu/2p1qaRDyJumKpm', 'Attorney III', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(13, 'kquibod', 'QUIBOD, KRISTINE MAE M.', 'kristinemae.quibod@minda.gov.ph', NULL, '$2y$10$RaEVp4cOKM/SLQjy2P045.hvOLHNHgNoYI5vCr.RC1YisYjW5Uvaq', 'Attorney IV', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(14, 'ecajilig', 'CAJILIG, EDWIN A.', 'edwin.cajilig@minda.gov.ph', NULL, '$2y$10$mihp3Xxt1XCGJ5wYey5TIuL0zFOtZjCaLdls2dcvdI.YMXXbFkfbO', 'Admin Aide lV', 'OED', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(15, 'mjualo', 'JUALO, MARILYN P.', 'marilyn.jualo@minda.gov.ph', NULL, '$2y$10$Ijc5dbXUBvu1MmdUfMudNOpVMmuJ0Y72ANq/97nRRkDVOmUZ6xvpS', 'EA lll', 'OED', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(16, 'jlopoz', 'LOPOZ, JANET M.', 'janet.lopoz@minda.gov.ph', NULL, '$2y$10$BkoteJWrtyBhLaK0ykTeY.t.VbpAos64LfSAjJedYDtgg/cR3eaIC', 'Exec Director', 'OED', 4, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(17, 'jlura', 'LURA, JEMBER ALLEN P', 'jember.lura@minda.gov.ph', NULL, '$2y$10$tbGWZNjiWTRXZblBMlmVX.GZAXnaXI3zW78wButO5M0wOwigN9Qyq', 'Admin Aide lll', 'OED', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(18, 'rmontenegro', 'MONTENEGRO, ROMEO M', 'romeo.montenegro@minda.gov.ph', NULL, '$2y$10$Uq.S2S42EUwn7zK1Hm45pefWUDCiVFmoWauejTsC80NBG5gQ39O7.', 'Director IV', 'IPPAO', 3, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(19, 'mtudlas', 'TUDLAS, MAYETTE S', NULL, NULL, '$2y$10$HuEirLQgcBjE.n43NBnTHOtJSw8gxc6CfvozyADbbRoCGxRlu6qhO', 'Exec Assistant IV', 'OED', 1, 'NoImage.png', NULL, '2021-02-21 06:14:57', '2021-02-21 06:14:57'),
(20, 'halonto', 'ALONTO, HONEY JADE V', 'honeyjade.alonto@minda.gov.ph', NULL, '$2y$10$UDYCj2qWJCsRIZgTOvCoBOkHdZvRy/dd9p9.c4V83As9frOcUBivO', 'AO V / HRMO III', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(21, 'mcaagoy', 'CAAGOY, MARICEL L', 'mariz.caagoy@minda.gov.ph', NULL, '$2y$10$Pki0lRbjt20Rto91H8Sf8eTr3Mq.3YeADhZcc6LKoiq41lq8Pvx6G', 'Admin Officer III', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(22, 'rcabilogan', 'CABILOGAN, ROMMEL C', 'rommel.cabilogan@minda.gov.ph', NULL, '$2y$10$lSrF3fQKu7gXQKyBRRn5POPlPsHwB5TZ26NbdWcr73mk44tJPYpu6', 'Admin Aide  IV', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(23, 'mcamagong', 'CAMAGONG, MA. CRISTINA S', 'kit.camagong@minda.gov.ph', NULL, '$2y$10$e7rCTb5lNv0T1m4uxJYPY.ITN2g/iFviDtWRP.U91ku9QDZX0jL0.', 'Admin Officer III', 'RECORDS', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(24, 'jduarte', 'DUARTE JR., JOSELITO R', 'joselito.duarte@minda.gov.ph', NULL, '$2y$10$iUzsTFaEqoejFsfiVS1nRORC6.mF9Z0X4fPk1gi5sA/ReJLWavc8W', 'Admin Aide  IV', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(25, 'cescano', 'ESCAÑO, CHARLITA A', 'charlie.escano@minda.gov.ph', NULL, '$2y$10$6Ebag2Eanr6yTgcAhA1W8unsv.zooHXBRinbTjL/8KxHmvVc25HHW', 'Director IV', 'OFAS', 3, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(26, 'gmalnegro', 'MALNEGRO, GENEROSO T', 'generoso.malnegro@minda.gov.ph', NULL, '$2y$10$E6rdSuWseX4tAKMUTfQXS.oBZFFkuc1.TZjVxoNM2vzhtXJrkHXEa', 'Admin Aide  IV', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(27, 'smarbas', 'MARBAS, SUNDEE F', 'sundee.marbas@minda.gov.ph', NULL, '$2y$10$ePt78VpzfWC7zX...3DmvOhnIMZ.Y9c.dm1N181pyYSYdO3T3eGvq', 'Planning Officer lll', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(28, 'fprieto', 'PRIETO, FLAVIA C', 'flavia.prieto@minda.gov.ph', NULL, '$2y$10$992AatC4n0UTMtEWdpO.3OiM/yW13dl/gtyzBF2SrS69V9UQwPQJ.', 'Admin Aide  IV', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(29, 'hpurugganan', 'PURUGGANAN, HERLYN G', 'neng.gallo@minda.gov.ph', NULL, '$2y$10$DB3slFrRNN5iz4lVPiqHQeanZTeKaTWKhLS5wgV9RYip1xLk3Eb7.', 'SAO', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(30, 'ctrino', 'TRIÑO, CECILIA D', 'cecil.trino@minda.gov.ph', NULL, '$2y$10$fDaxPMXI7l2aqpwhHrnjDeBVywSktOKPqa/ys8so5HhpU4n3wpkxu', 'CAO', 'AD', 5, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(31, 'mverzosa', 'VERZOSA, MARY ANN', 'maryann.verzosa@minda.gov.ph', NULL, '$2y$10$0LfIaNTnNIodumJXhDLfZevWZJUqpihMxT/YdkyoVNoK4NoaT26.6', 'AO II', 'AD', 1, 'NoImage.png', 'ML4yVw1sYBE4l8YspAtQWKmcKd1YiolX0e8BFeXXvdIGj7aoI4MnjEI8uaJN', '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(32, 'rcastillo', 'CASTILLO, ROMMEL S', 'rommel.castillo@minda.gov.ph', NULL, '$2y$10$2mhfqXTKI2r9wuD.jEDyH.qQveATURsHB7xXYhv0nZjc2Fz./J7KG', 'CAO', 'FD', 2, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(33, 'acuello', 'CUELLO, AURORA J', 'aurora.cuello@minda.gov.ph', NULL, '$2y$10$4Su9ozRPoM4/la7NXUVcvufHyy4YVSauUk4d2jR6Qtkuuykx6DEze', 'SAO', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(34, 'spines', 'PINES, SHARLYN JOY T', 'sharlyn.pines@minda.gov.ph', NULL, '$2y$10$HR0ynh0rB.LuYKNjt/bsceBKQ32jBJHcER0Mzi8fyRy9nyEvtdTDK', 'AA VI', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(35, 'ssantiago', 'SANTIAGO, SHARON D', 'sharon.santiago@minda.gov.ph', NULL, '$2y$10$Q85TfV.pDtivF1vJqwWbx.prObHYCkXVuv6bXRRWs4FEmT.7PO9kO', 'Admin Officer V', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(36, 'msarigumba', 'SARIGUMBA, MARIVIC', 'marivic.sarigumba@minda.gov.ph', NULL, '$2y$10$rpNc.qazaVK65AC19OG6GOROIBOCoYxclvvc9Bn5fS6UFXbV96Aum', 'AO I / Cashier', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(37, 'dtancio', 'TANCIO, DAHLIA MONICA D', 'dahliamonica.tancio@minda.gov.ph', NULL, '$2y$10$hOG1XEgGwCo3j6iqjTsXeO56bdgTQiT/gw3faTr7cC1oaq0O/3lSS', 'Accountant lll', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(38, 'rabril', 'ABRIL, RUEL P', 'ruel.abril@minda.gov.ph', NULL, '$2y$10$bqJpmSZkJXETndOb38LpPulo/stoANj.Fe4tOJ36qeBnYw.WBQovG', 'DMO ll', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(39, 'abinancilan', 'BINANCILAN, ANELYN G', 'anelyn.binancilan@minda.gov.ph', NULL, '$2y$10$5xM.KQD2ZcGHvxJlqEuxB.6GKQEuY8G5kYvO/RNgt4AyhAycHmcXS', 'DMO lV', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(40, 'hdecastro', 'DE CASTRO, HELEN', 'helen.decastro@minda.gov.ph', NULL, '$2y$10$K08/GoRUvCCzfW8Mi6gzuOBUnz3ycsksYeo12G/RxI/1KfFVb61Aa', 'DMO V', 'IPD', 2, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(41, 'resperat', 'ESPERAT, RAYMOND PETER D', 'raymond.esperat@minda.gov.ph', NULL, '$2y$10$VAa0aIHnCqr0HFTymlOCSuwmC5Xuukbn8JLWeEZ0QTHZhYl0f6eoK', 'DMO lll', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(42, 'jgan', 'GAN, JOHN MAYNARD V', 'johnmaynard.gan@minda.gov.ph', NULL, '$2y$10$.GEw7O6Z3IbFLL6zf4gW3eGfIA420z4SV.nKtkj4Rkgt7iwnhc5I2', 'DMO III', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(43, 'mungab', 'UNGAB, MICHELLE MARIE B', 'michelle.ungab@minda.gov.ph', NULL, '$2y$10$owMf93Xt08fEwP49U3QHSuT4nn/m69JJrIInOKwoono9Iwo/NjT.S', 'DMO l', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(44, 'wvillanueva', 'VILLANUEVA, WILLIE C', 'willie.villanueva@minda.gov.ph', NULL, '$2y$10$bg10Am9wGUxkkWyf7/.T9eWXN09qDz6FTPSRXtkINo6QpvRUTZMlu', 'AA lll', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(45, 'iarnoco', 'ARNOCO, IVY MAE G', 'ivymae.arnoco@minda.gov.ph', NULL, '$2y$10$.c5fUMiaaRqpSQlwQ5UeTey284HUOtFrZe9k7K3JBNT6GEddRFqOG', 'DMO l', 'AMO-CM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(46, 'rbuhat', 'BUHAT JR., RENATO', 'renato.buhat@minda.gov.ph', NULL, '$2y$10$n.JtA6bsZl8WjY9tR4tCpu3ZNXPbFoYya/EdVUXnwbr76BxpZs9oS', 'DMO lll', 'AMO-CM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(47, 'gcapulong', 'CAPULONG, GINA RUTH C', 'ginaruth.capulong@minda.gov.ph', NULL, '$2y$10$z0PDMmCLKXcqW.o6Ra6qsO.q/pdtIqvrqDuL4s1FV29dKHdJ/lGdS', 'DMO ll', 'AMO-CM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(48, 'greynaldo', 'REYNALDO, GERARDO RAMON CESAR', 'gerardo.reynaldo@minda.gov.ph', NULL, '$2y$10$0xU2.oAHde2do1ugj52XUeoZvQH6LH/OkYPYniRZf3gcwRB9R8Vlq', 'DMO V', 'AMO-CM', 2, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(49, 'raguaviva', 'AGUAVIVA, RACHAEL', 'rachael.aguaviva@minda.gov.ph', NULL, '$2y$10$PSgdKBVWR3O6KR6MV/vQGOYjQ8MLBFMCrXS1QdNcVdTPYdd48F.A2', 'DMO ll', 'AMO-NEM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(50, 'elawansa', 'LAWANSA, EMELIAN L', 'emelian.lawansa@minda.gov.ph', NULL, '$2y$10$dlHfzpldpges.SUVKZB7.eQFtgyA5yfQvrqsGsR5V3VYob4Wm0Jri', 'DMO V', 'AMO-NEM', 2, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(51, 'ipiong', 'PIONG, IRENEO JR S', 'ireneo.piong@minda.gov.ph', NULL, '$2y$10$AM7CBQcslDTWjlRBw8iVK.yKekLBZcuclfa6W5ty4lksD3cFtRV6G', 'DMO lll', 'AMO-NEM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(52, 'asultan', 'SULTAN, AMINAH O', 'aminah.sultan@minda.gov.ph', NULL, '$2y$10$6VjhMIGveIzsyuUCjBZhdOBwwOI.6iYV9owHnR6UMzGSKTM1QNk/y', 'DMO l', 'AMO-NEM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(53, 'odagala', 'DAGALA, OLIE B', 'olie.dagala@minda.gov.ph', NULL, '$2y$10$6tUpWs2eup5wt5m6LZwUmu07BG3ii8gc03gbzO9tH3p4fsOgphDpy', 'DMO V', 'AMO-NM', 2, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(54, 'lenjambre', 'ENJAMBRE, LORDILIE S', 'lordilie.enjambre@minda.gov.ph', NULL, '$2y$10$mdXPT0maFnWLW6r4JRfJquqXCZhNpKJJJEOkfTV39uNnq/w.iXLQO', 'DMO lll', 'AMO-NM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(55, 'wmabale', 'MABALE, WILSON D', 'wilson.mabale@minda.gov.ph', NULL, '$2y$10$zWPUUWyJDUJepInb68Zv7uxytYO0E4C1PkVm6.ohCud23fJJ/f8u.', 'DMO ll', 'AMO-NM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(56, 'ccerezo', 'CEREZO, CARLOS', 'carlos.cerezo@minda.gov.ph', NULL, '$2y$10$rKUBrk1HH1h8kV6qD0Q/m.PkF0UOOZZOA3qZO1HsSbhKDTEu/m.d2', 'DMO V', 'AMO-WM', 2, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(57, 'claplana', 'LA PLANA, CECILLE A.', NULL, NULL, '$2y$10$YXweYdDANsbMM2Q7W5FqSuNAPL.LeulpVBAFV6Rn8taRQznD3e28O', 'DMO II', 'AMO-WM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(58, 'jtolentino', 'TOLENTINO, JEAN PAUL', 'jeanpaul.tolentino@minda.gov.ph', NULL, '$2y$10$c9HJDiBP7HntAHLvq7M/VOLLO6.r7XgmUU1saz.SCDvF3KYdERd5C', 'DMO l', 'AMO-WM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(59, 'rvisitacion', 'VISITACION, ROGELIO', 'rogelio.visitacion@minda.gov.ph', NULL, '$2y$10$TO9VPg6hml40kTbguiV5GeQiEQ50exM6bdSVOYQkaKEe9Ib1sb/Cu', 'DMO lll', 'AMO-WM', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(60, 'salmasa', 'ALMASA, SHEILA B', 'sheilamae.almasa@minda.gov.ph', NULL, '$2y$10$odRyFKiEWhE4Aj5Y8Yl4y.eK.uWV2RXEFI6P4nfb8k61MZZV.ci9q', 'DMO lll', 'PFD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(61, 'mapurado', 'APURADO, MARJORIE M', 'marjorie.apurado@minda.gov.ph', NULL, '$2y$10$sgfFKCTxhdMp8pYj6/m0veqjNG9PakWbJgN3WghKV2.MKzqDP1ufe', 'DMO Il', 'PFD', 1, 'NoImage.png', NULL, '2021-02-21 06:14:59', '2021-02-21 06:14:59'),
(62, 'lbruce', 'BRUCE, LADY LYN A', 'lady.albarico@minda.gov.ph', NULL, '$2y$10$xvmdWzOtS4rYID4vlqbY0urlHwjDMDkAdKUk9v4G/UfTodpRaDGvy', 'DMO l', 'PFD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(63, 'mginete', 'CUNANAN, MA. CAMILA LUZ G', 'melot.ginete@minda.gov.ph', NULL, '$2y$10$RDdlR1w6qY2zrs.jgI/Rr.j91IxdxuLM.LibFei6oQKL7VBT5zmMG', 'DMO V', 'PFD', 2, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(64, 'aleparto', 'LEPARTO, ARGIE S', 'argie.leparto@minda.gov.ph', NULL, '$2y$10$ftsGaEPi6s1XMIJ6Ci2C.uQMFio45c8AUh8XSqm7/xHlm0RApKjri', 'DMO V', 'PRD', 2, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(65, 'kmaquiling', 'MAQUILING, KARL SAM M', 'karl.maquiling@minda.gov.ph', NULL, '$2y$10$u/MyXCfm3URBjjHRIalIduZjGyATBX8wXV4tuE4PAtynjVh0hBSZy', 'DMO III', 'PFD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(66, 'msullano', 'SULLANO, MARLO D', 'marlo.sullano@minda.gov.ph', NULL, '$2y$10$v7neLbg2U1o70jJrYLHVBeRW8FRdopKOR5YYeJMCJOii7VqkeXMPG', 'DMO lll', 'PFD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(67, 'dbacongallo', 'BACONGALLO-CABALINAN, DIANA S', 'diana.bacongallo@minda.gov.ph', NULL, '$2y$10$VPu1N1SY8M0fRoxgTetpmOBcYfutCnB3G2Smzs5TMElVuznS8NSKq', 'DMO ll', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(68, 'rcornita', 'CORNITA, RUDISA B', 'odie.cornita@minda.gov.ph', NULL, '$2y$10$XbY3Qfu.1TRYJA5Q6p3JteAzopXESi3i1ldFY/V30tiAtveaIT/fu', 'DMO IlI', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(69, 'jcristobal', 'CRISTOBAL, JASPER', 'jasper.cristobal@minda.gov.ph', NULL, '$2y$10$9p0qtV2VVNHVnaTiU27zmODe02JyjVGSO2fSFV9rt30DlTBjCxUDi', 'DMO IlI', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(70, 'kgeldore', 'GELDORE, KATHERINE ZENITH L', 'katherine.geldore@minda.gov.ph', NULL, '$2y$10$U8SI19q2eFpspnp7yDbbR.0kbzsVpxP62YBtbt5DtprysnFePeWMu', 'DMO ll', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(71, 'mpasawilan', 'PASAWILAN, MAKMOD S', 'makmod.pasawilan@minda.gov.ph', NULL, '$2y$10$TxcDGqXM0qzjomUbnJ6C..cJL0Po94Lrhj2Xg5e.oHleaCHIUKTY6', 'DMO IV', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(72, 'jrecimilla', 'RECIMILLA, JOEY E', 'joey.recimilla@minda.gov.ph', NULL, '$2y$10$2hOabACs4BTg4rWf0WnP0O.3sAyND/ffrNKUpnmEHS5WKGxUVuEIm', 'DIR IV', 'PPPDO', 3, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(73, 'ahernaez', 'HERNAEZ, ANITA D', 'nitz.hernaez@minda.gov.ph', NULL, '$2y$10$zeWCkSJEPXl/SZ0moZBspuYmm.vNTHm8jwNJpOkY/NYrcoIGbiAiK', 'DMO l', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(74, 'jbarrera', 'BARRERA, JOAN S', 'joan.barrera@minda.gov.ph', NULL, '$2y$10$3i5xu0yDVIHN1oqHsIbWUOG1QSW5Glw40KnnxtGaomtjqB5anrWcW', 'DMO V', 'PDD', 2, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(75, 'mcasinto', 'CASINTO, MADANIA M', 'madania.malang@minda.gov.ph', NULL, '$2y$10$pwfS/NacmVHJpMsEkr9RaeVqK.e24iwMssBg6/8JjHqi5TIDzndl6', 'DMO lll', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(76, 'alabor', 'LABOR, ANA MARIE A', 'ana.ayano@minda.gov.ph', NULL, '$2y$10$a2UCqNcMr99SxfGusipgKOrP2fmli5lSdvq/2D1fa0SMNrAIXE6Oa', 'DMO II', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(77, 'rpinsoy', 'PINSOY, ROLANDO B', 'rolando.pinsoy@minda.gov.ph', NULL, '$2y$10$hNB.ahpBxRVksxB0OkCmSe0FHZC2z9Na2nxPnQw95HR3TAaSodKZ6', 'DMO lll', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(78, 'areyes', 'REYES, APRIL ROSE E', 'april.reyes@minda.gov.ph', NULL, '$2y$10$3FcFnxT8WIbLlKfql2tQHOo06k.J2104lHA6V0W3dGTKeFkgdg1ua', 'DMO ll', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(79, 'jsolera', 'SOLERA, JODEELYN C', 'joedeelyn.solera@minda.gov.ph', NULL, '$2y$10$CUuG10Sz6ScVxkNdm/nz9eRjFgDExzSb2nDsXwqX7EwaxiP26orW6', 'DMO I', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(80, 'yvalderia', 'VALDERIA, YVETTE G', 'yvette.valderia@minda.gov.ph', NULL, '$2y$10$o0DnJQ.0uSNtRwvhmGFKverV8GQ/IlQqzTB1Mo0jDDCPn4W2o.QmS', 'DMO lV', 'PDD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(81, 'rbaguio', 'BAGUIO, ROSEMARIE ANN O', 'rosemarie.baguio@minda.gov.ph', NULL, '$2y$10$wQeDwngW3iXBxXSkQA1J1OuJObb5dbgij4WvE3WMMd9wrklqZ52kC', 'DMO l', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:00', '2021-02-21 06:15:00'),
(82, 'fflores', 'FLORES, FRITZ E', 'fritz.flores@minda.gov.ph', NULL, '$2y$10$FGBDbV2dTplFxOoeYfs.ZOXCv0DoqLyhowcUTzYC2jJq7I7aV.tFO', 'IO lll', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(83, 'kmateo', 'MATEO, KATHY MAR S', 'kathymar.mateo@minda.gov.ph', NULL, '$2y$10$xDjViTp11GH5jbIRep0.ZOKe3roCXrAlgQjBubIwykGPSQXCs14BK', 'DMO IV', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(84, 'jmusa', 'MUSA, JIMMY K', 'jimmy.musa@minda.gov.ph', NULL, '$2y$10$W180MKDpeVaj9v1XvefsVupj1VesP86ihXBPTQ2YuKdZeZYbU6/3m', 'DMO lll', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(85, 'iquizo', 'QUIZO, IRIS MAE F', 'iris.ferraris@minda.gov.ph', NULL, '$2y$10$0nS7EH3eD67GtZPPZH06bOVQTp04vfIPjsOUVLRHN0X8KmVRh7D5C', 'Info Officer ll', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(86, 'atamayo', 'TAMAYO, ADRIAN M', 'adrian.tamayo@minda.gov.ph', NULL, '$2y$10$RUyS2P/uEs9CqB4sQaPWzOuBI6H078j6kdGkW6wtfVe6gCCKUpRfe', 'DMO V', 'PuRD', 2, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(87, 'rgador', 'GADOR-RAMOS, ROXENNE V.', 'roxenne.gador@minda.gov.ph', NULL, '$2y$10$gHvSdSNpGZ.G4S/RlgNii.LLjs9Lkp65t3FsoWRafQOFPmsWMaY0.', 'DMO l', 'KMD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(88, 'rmondido', 'MONDIDO, RICHIE MARK T', 'richie.mondido@minda.gov.ph', NULL, '$2y$10$804oN.fTe4pHTYeS.9l.TerjH.ccvCcFkXJk1TAQdmbh/yB0hhMlC', 'ISR II', 'KMD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(89, 'rtejano', 'TEJANO, RAYMOND R', 'raymond.tejano@minda.gov.ph', NULL, '$2y$10$Nr2/ScvYP4b5y4nhRqNRpOu8ZWb.W4cLP9cPhG7e0Kyu.FJKJV3JC', 'ITO II', 'KMD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(90, 'etomas', 'TOMAS JR., ERNESTO M', 'ernie.tomas@minda.gov.ph', NULL, '$2y$10$uqWmO8I1obzceEj4jwsFHOPtiOD0fRM9ktLujN1WGTgfsDPcsiV9i', 'ITO III', 'KMD', 2, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(91, 'vacosta', 'ACOSTA, VIGILIO JR M', 'virgilio.acosta@minda.gov.ph', NULL, '$2y$10$p7asn2tUVbYAY0YGYrwviOTF9/7LJxkYbtc1sUdjgVDnTgyxEhsdG', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(92, 'rbotenes', 'BOTENES, REGINE S', 'regine.botenes@minda.gov.ph', NULL, '$2y$10$IPe/s6/Gh8lUgvrZHAUFAuc8XjM0zz5z0iBGNSwbgk2/hOSZoTxku', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(93, 'icodal', 'CODAL, IRISH JIREH A.', 'irish.codal@minda.gov.ph', NULL, '$2y$10$tWu3Zn7jOm7Rav7KK8FAB.jjnK8w4XHd9zz1Vl7b9NiZ5RE2Foa8m', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(94, 'mdemarunsing', 'DEMARUNSING, MASRON C', 'masron.demarunsing@minda.gov.ph', NULL, '$2y$10$ka9UldRXk/eml0GTD0pYTOlpSD3dxNv.gI3kFyLoVBozidIu/Td4u', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(95, 'restampador', 'ESTAMPADOR, RODERICK C.', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$6A9tW8Kk.qEHLVpH4tuqe.fT53OEtbP8tp4Sp3tDjAYYASe9zkiH6', 'Admin Aide', 'RECORDS', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(96, 'jesteva', 'ESTEVA, JEZA MIE B', 'jezamie.esteva@minda.gov.ph', NULL, '$2y$10$qpQuaIaG2GGrtGzjnR346u0fCuCYnJCZ3ULZoMB/XXRNeGurMZutC', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(97, 'thuestas', 'HUERTAS, TISHA CORRAINE', NULL, NULL, '$2y$10$4Vh2mUsuKHI/frB0FmbOm.Gs2j6QlR5f29FR/Px4zwqkyqF9rF9Wi', 'Administrative Specialist', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(98, 'bjavier', 'JAVIER, BENEDICTO A', 'benedicto.javier@minda.gov.ph', NULL, '$2y$10$daTO9RKnHYdHeO7FNuMKrO5hFxzuZ8wO2uFqrA8oxr7lNZywmSvSC', 'Administrative Specialist', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(99, 'llorenzana', 'LORENZANA, LIDDY JANE', 'liddy.lorenzana@minda.gov.ph', NULL, '$2y$10$JCLxnENSsy9bSb4dAPL3h.yEFHRsCs.r5HN377IuJuBihveijzUai', 'Administrative Specialist', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(100, 'lquintero', 'QUINTERO, LALAINE F', 'lalaine.quintero@minda.gov.ph', NULL, '$2y$10$pRJalmu25icwXa4Raqp4TuQqdAIRzoyALq8FqoRhVOqQkDdIctT56', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(101, 'ksarino', 'SARINO, KIMBERLY JOY D', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$ivRBx55tprvejSAs1oO.Cu9UFlBE5a4y/vfIQ9w6p75rRT9q8wwZC', 'Administrative Specialist', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(102, 'ltagab', 'TAGAB, LUZEDELIO', NULL, NULL, '$2y$10$xojw2VTYktufORjx3f5RpeE1Mqr8GphIn/2/fF0hAeHv6ENmNpaZC', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:01', '2021-02-21 06:15:01'),
(103, 'mtapanan', 'TAPANAN, MERLY C', 'merlytapanan@ymail.com', NULL, '$2y$10$OlVQ.hnQVozXFtyFRyKmAOHpNNGzc6JgVZz8HZi0yiLR0sOR0intC', 'Administrative Assistant', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(104, 'ntorrecampo', 'TORRECAMPO, NEIL S', 'neil.torrecampo@minda.gov.ph', NULL, '$2y$10$qd9KP6WibGtQgGe6EsfP/ubfcNK5y.XFMj.OqL8TfviKmuYNOepwS', 'Driver Mechanic', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(105, 'cveloso', 'VELOSO, CESARIAN C.', NULL, NULL, '$2y$10$/mWjT67i2UTphH76kZEgaedlHYp5QCvHG7nFvYGa8qOYjfsg/hDuC', 'Driver', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(106, 'pvillorente', 'VILLORENTE, PETER PAUL C', 'peterpaul.villorente@minda.gov.ph', NULL, '$2y$10$gufx3eGrRzpfLFG3Ua.fI.48Zq.df9jfUk25OJIbqzPpReI35EVaG', 'Administrative Specialist', 'AD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(107, 'jruiz', 'RUIZ, JERRY A', 'jerry.ruiz@minda.gov.ph', NULL, '$2y$10$H8Gp61LJNBJMiGwyEN16E.xXMvypY6LrnBA.KhOL1NcCJLm1owrSa', 'Driver', 'AMO-NEM', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(108, 'racosta', 'ACOSTA, ROGELIO', NULL, NULL, '$2y$10$y/MuuYk87iO/fcAtHr46euUbI50FzuBupse.izByHAYhjePSHw2T.', 'Liaison Officer', 'AMO-SCM', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(109, 'adaanoy', 'DAANOY, ARCHIE D', 'archie.daanoy@minda.gov.ph', NULL, '$2y$10$hRlBWa8To8N/ucY4dAI8PeWAluSXoqKd7wQ5weNwxurf8Vbaz9Zt.', 'Driver', 'AMO-SCM', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(110, 'rasdillo', 'ASDILLO, RANDY P.', NULL, NULL, '$2y$10$UiVVWvM.SmasYjv8tZltMuzeilDbR8PPFHR87sXvOK4nnZLnaXi12', 'Driver', 'AMO-WM', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(111, 'eancheta', 'ANCHETA, EDWIN V', 'edwin.ancheta@minda.gov.ph', NULL, '$2y$10$MwiVtwoFAx8xUkJJbCgT0..LSOtqO1VR0pPe0PZFzU5N.68fXMYgm', 'Finance Assistant', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(112, 'jbustamante', 'BUSTAMANTE, JOHN MICHAEL T', 'johnmichael.bustamante@minda.gov.ph', NULL, '$2y$10$pGpVazuIDKU2LOzf0v7zjuOoT6qEKxzkUcRdfMHufJguIvb2GZz0G', 'Administrative Aide', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(113, 'wfernandez', 'FERNANDEZ, WYNCELL L', 'wyncell.fernandez@minda.gov.ph', NULL, '$2y$10$OYnxgwo85KYfaxHAPVcqH.t77XEQmW/UOJoCaDKQXpbNvo.e6F2L2', 'Administrative Specialist', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(114, 'gmaghopoy', 'MAGHOPOY, GLYDSI FEDERICO C', 'glysdi.maghopoy@minda.gov.ph', NULL, '$2y$10$8n3EkKtoNdjH9wQHX3WHiOsRUhFpJGTtfobYfl2szpW07TIgmVDXS', 'Finance Assistant', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(115, 'ltabla', 'TABLA, LOYGIE H', 'loygie.tabla@minda.gov.ph', NULL, '$2y$10$tuwDKrPX.8f.pQy98iFUyOdM8S70YeOPt9x3/khvGJPpSpbKCfFC2', 'Finance Assistant', 'FD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(116, 'ealerta', 'ALERTA, ELLENE B', 'ellene.alerta@minda.gov.ph', NULL, '$2y$10$MZMnWliJDBDQ03E1z.C4teI.PdSSAxbDCBoMvpp.w/fJ2L.oDrnxW', 'Technical Staff', 'IPD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(117, 'icasan', 'CASAN, INDERAH M', 'inderah.casan@minda.gov.ph', NULL, '$2y$10$7sUEGDbNpPz6YxEzgL/AAOOzxtEqb8JR2Z0Yv863qmhdWoUBl.dsy', 'Administrative Assistant', 'IPPAO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(118, 'jdoldolia', 'DOLDOLIA, JAMES E', 'james.doldolia@minda.gov.ph', NULL, '$2y$10$98F5y//H4YSmZ69k2bXhS.X1t2cNHGJbEhnnQvH2KDKxKTnnoU2/m', 'Technical Staff', 'IPPAO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(119, 'alabrador', 'LABRADOR, ANGELOU S', 'angelou.labrador@minda.gov.ph', NULL, '$2y$10$aUMf4WbRzu.SSk0s4.rm5uJXvaXwYPJp2rdDxeUW5EZJUQ.UD71LO', 'Administrative Specialist', 'IPPAO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(120, 'ragor', 'AGOR, RALPH LAURENCE A', 'ralphlaurence.agor@minda.gov.ph', NULL, '$2y$10$CvME69D4rdSEXnNrZn0sI.2s3NneHacoWW10iY2d73lMXeQvKDaHq', 'Information Technology Support', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(121, 'eajanab', 'AJANAB, EYSSER ALEJANDRO E.', NULL, NULL, '$2y$10$i2nm0659PHdqgCzcr9oYj.DL0kDeq8genW3oyiJpCaOpTbqIIHvpm', 'Driver', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(122, 'nantipatia', 'ANTIPATIA, NARENO C', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$Y3DzXwsCoS3ekp./6ga/gucxD5shvdtxWeTaeKpjlRueWZA7WcMXa', 'Administrative Specialist/Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(123, 'dasentista', 'ASENTISTA, DANA VICTORIA I.', NULL, NULL, '$2y$10$X6qzkmEj1DpQHjm9XODm3OXYpIAl50YWnGze0gV5H/2TqG0g/qVjG', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:02', '2021-02-21 06:15:02'),
(124, 'kbahinting', 'BAHINTING, KATLEEN FRACHESCA L', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$Eyd3JxJ2nvh3XZzkhNplIu7LZP7FsNR08ZDmf1gQTdYuQFg0Jgf1m', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(125, 'gbangcaya', 'BANGCAYA, GENEVIEVE A', 'meriam.eumenda@minda.gov.ph', NULL, '$2y$10$gDuTYVPFTe9AOGvvpsMLq..8hiRYj3V7Jtr5z04h02/BgXMybf4m2', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(126, 'ccaedic', 'CAEDIC, CHARITY MAE B.', NULL, NULL, '$2y$10$Pn3/k51q5fbJS1bYMc.1HeIkw8h1K8BW9yO9kmLLjV3MFayafIHny', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(127, 'jcalotes', 'CALOTES, JEAN T', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$FDk5MEuJj9mVju9h27s4IecfIY5EYVh.kbLrnvs3MPbaeW2uLKsi2', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(128, 'ecasumpang', 'CASUMPANG, ERNESTO M.', NULL, NULL, '$2y$10$/qN03qab9RJFoI6ojC5K4OTxXjQ9WzlbwsWCnaXQzDSVLOb2c9KQy', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(129, 'mcayona', 'CAYONA, MARAH JANE G.', NULL, NULL, '$2y$10$HF6NDr990sVKPDgiJKoL7.FnuUWeu65EyfXC1cs13W0IVm10FcOdK', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(130, 'edapudong', 'DAPUDONG, EDRIN P', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$BFuJWw2pGBXneL0Kkxr80OzMm9B6LANrECQbWzcPtt9PW.S5NqCuu', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(131, 'gdeasis', 'DE ASIS, GINA T', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$6g5n7aKdGesIFRF8Fsa/0OiXUQUtSkahwHETZUh6s29A8m/s36wIy', 'Admin Aide', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(132, 'mdelacuesta', 'DELA CUESTA, MONICA KERSTIN', NULL, NULL, '$2y$10$pxVFClUDSnxJ9OUKHG8D2e7qvik79/P6E.8eDQwVIlGTiRlfIhj7i', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(133, 'jestampador', 'ESTAMPADOR, JOHNYLYN C', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$yg9Pg6t4LFhTLQZwC4AVUe/DL0kt38O1cRpAFy/PeuVgsNl9Oqsc6', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(134, 'ffrades', 'FRADES, FREDERICK S.', NULL, NULL, '$2y$10$1Nl.geo6LsWRRVYEU3zvKuVXJ.L5P90TE5hMudsWuM8k1JgWSUwgK', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(135, 'rfullente', 'FULLENTE, ROMELITA D.C.', NULL, NULL, '$2y$10$h3.XIjZouSo6TugW9w6dS.y2Wl65H3LaZfn8jRswEv51erGVcBWyO', 'Administrative Assistant', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(136, 'jgarcia', 'GARCIA, JOHN CARLO S', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$iS33T6Q1yb6Xreuf39IdN.GWvuL4A.RQT8k5aDQ3LXDlJt3rvGjpu', 'Administrative Specialist/ Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(137, 'cgarocho', 'GAROCHO, CARLOS N.', NULL, NULL, '$2y$10$KfkHeu6NrqFqB8Nq7fMejewUkGJS/GKt4kAZfcJnI6wNShLV2RttG', 'Administrative Aide', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(138, 'ngranzo', 'GRANZO, NELSON T.', NULL, NULL, '$2y$10$.L/FdbUtjaCYjzAGyfGZQ.uEyLQUwKqL7KQv1qqbex71ezSwvJFu.', 'Administrative Assistant', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(139, 'ggumatas', 'GUMATAS, GERALD V', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$IMQhvEPayizzeT0q8GeJuuCxK8P5YFScAHNHQp5amD1E50.Dxobvy', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(140, 'emalli', 'MALLI, EDWIN M', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$sXM2iwQY7CQqD69rFCkXA.kr7xwnhrcSEvi3kegkLs9GK.FHKjs2.', 'Security and Peace and Order Officer', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(141, 'amerto', 'MERTO, ALVIN JAY B', 'alvinjay.merto@minda.gov.ph', NULL, '$2y$10$L9g/bU4T9HM6rR3ocuQP7ewd6Jmg9pJvwUxKX3YYZMr9g9A4y.op6', 'Software Programmer', 'OC', 1, '01ba4df0e819b5f042e292d2ecd5155f.jpg', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(142, 'cnieve', 'NIEVE, CAMERON B', 'cameron.nieve@minda.gov.ph', NULL, '$2y$10$u3G.NbHJMuv/ExgEhxEm5eEfGgmg.v6fMqFIWQkZTQ.dYubuHHJFq', 'Software Programmer', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(143, 'rpenaloza', 'PEÑALOZA, REX M', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$B3HptjwzLZ3G2I58DIEUb.txjj/xrDP/SreGZ0z8ed18xFIGAG0mm', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(144, 'rpenas', 'PEÑAS JR., ROMEO S', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$6i0SMTG7cS3s2KfKnVDw1eJYANJAG9IdU/7bV8xmdVCMSAth91ov6', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:03', '2021-02-21 06:15:03'),
(145, 'kpios', 'PIOS, KURT STEPHEN', NULL, NULL, '$2y$10$xjPCtKWFw7pynKSrFtFiv.tnJgXl7meQqDw94WKdtxkuoLkeb8p2a', 'Technical Staff', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(146, 'jrazonable', 'RAZONABLE, JOEY B.', NULL, NULL, '$2y$10$H5AFHeJxUe5lQwd2d4iZL.R2RujrTsxeAKIFKHJlFcZVIJjSMfRui', 'Security and Peace and Order Officer', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(147, 'joules', 'RICO, JOLITO DESPOSADO', 'jolito.rico@minda.gov.ph', NULL, '$2y$10$ga4cxA0uVXmBO3NTxZBwruGxbBL.kp7qa6reHeJXDpz0xIs7ZAAwG', 'Software Programmer', 'RECORDS', 5, 'a5d8b037636471c73e5d60892e66e1d2.jpg', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(148, 'fsolis', 'SOLIS, FREDERICO P.', NULL, NULL, '$2y$10$.LGyaS6NNAEpuBGueumjpuZi.TE/8S5eMqYZzvmUD7py0.5qvlbZS', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(149, 'jtupas', 'TUPAS, JOYCE O', 'kathleen.bahinting@minda.gov.ph', NULL, '$2y$10$zz9Wygbo3a8v6xKrXZnASOblRfmpcxwALb2YVN7j17tnMxRrn8Hie', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(150, 'svalerio', 'VALERIO, SOCRATES', NULL, NULL, '$2y$10$Hz92wvQsLnwDqV2qmU8Ej.NQP9s3.kdxmmB8gIO.w/aNqNnq1wyHK', 'Administrative Specialist', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(151, 'avido', 'VIDO, ARNOLD M.', NULL, NULL, '$2y$10$1CUPTppnuX/Wfp1opm5jJuVQ/sKOucWUQDyTysGJciTGr1VLhMBZO', 'Security and Peace and Order Officer', 'OC', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(152, 'abondoc', 'BONDOC, ALLAN DOMINIC C', 'adcbondoc@gmail.com', NULL, '$2y$10$RrkUqwOgrdjbqknot1oS0OpPHsVvgAJwk1D1UlZcXBly8mGdO7ZD6', 'Administrative specialist', 'OFAS', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(153, 'rluna', 'LUNA, ROTESSA JOYCE A', 'rotessa.luna@minda.gov.ph', NULL, '$2y$10$mWiG9OpyaeTvYWOf7PV1UOwtpedAGU6xSnA7CxDaEuC21WW3xw6Wa', 'Administrative Assistant', 'OFAS', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(154, 'lfuentes', 'FUENTES, LEA V', 'lea.fuentes@minda.gov.ph', NULL, '$2y$10$ifoDHlFdPM6zCyCkICT6wucHdw9MBOLhFK8NRlhRWtt15ebRqoUde', 'Administrative Specialist', 'PPPDO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(155, 'rmanongdo', 'MANONGDO, RALPH R', 'ralph.manongdo@minda.gov.ph', NULL, '$2y$10$3/lM28bHjlhPEqD/5XNCDeCPa6CKte5xwjvqW9R1L5dogihLUatJK', 'Technical Staff', 'PPPDO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(156, 'meumenda', 'EUMENDA, MERIAM P.', NULL, NULL, '$2y$10$jGH7fgKS11zsDRf6EAwnEOILlvQPe67PUGRrx9fV.XaC9HwF8VYYy', 'Administrative Specialist', 'PPPDO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(157, 'olegaspi', 'LEGASPI, OLIVER V', 'oliver.legaspi@minda.gov.ph', NULL, '$2y$10$R6WKCet6Zr20ZVhB1wgn1.CrrakO9BJHIFz1Xz8iRPQ0SGkjW8/T6', 'Administrative Assistant', 'PPPDO', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(158, 'tolasiman', 'OLASIMAN, TERRY R', 'terry.olasiman@minda.gov.ph', NULL, '$2y$10$sAasbKHnkcymezse3yJAlusYwvwHkI8lbirTZ.dxvQ9aAdo/yJ6bm', 'Administrative Specialist', 'RECORDS', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(159, 'dtan', 'TAN, DONNREY ', NULL, NULL, '$2y$10$w0bRmpjxj23EbmbDiu9ik.JM5hr0NbyBT9ci/Yd2hkdglnc0DVpTG', 'IT Support', 'PRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(160, 'rducay', 'DUCAY, RICHARD C', 'richard.ducay@minda.gov.ph', NULL, '$2y$10$nEcIrMmpp9jFGt1JlQ18vusdifZHyfzZQ2.cAq3C9JehZXfI4SwB6', 'Administrative Assistant', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(161, 'sfajardo', 'FAJARDO, STEPHEN JUNE A', 'stephen.fajardo@minda.gov.ph', NULL, '$2y$10$iRPl81614ydGbzjYaxMx5OlFEcZrCKGJg7af1jToS2HAMG4UKdBFu', 'Media Expert', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(162, 'sponsica', 'PONSICA, SAMUEL J', 'samuel.ponsica@minda.gov.ph', NULL, '$2y$10$ZBNeT4TMXTvJg7RAdLvUgOAS34nowLdnMrytBoutSu/1tcLhjCMzC', 'Graphic Artist', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(163, 'ssaldivar', 'SALDIVAR, SAMUEL D', 'samuel.saldivar@minda.gov.ph', NULL, '$2y$10$495aKBhVXQnicXp13H5o9.2D9XmUU1O0J7rF60cVoJ0B.bbezRISm', 'Social Media Content Editor', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(164, 'ptrozo', 'TROZO, PREXX MARNIE KATE M', 'prexx.trozo@minda.gov.ph', NULL, '$2y$10$ufFdJODnl4/u094luDF9KuUpK0cVRIjih4ywOavHdI8siyDUipUCa', 'Writer/Social Media Content Editor', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(165, 'ctuazon', 'TUAZON, CESAR', NULL, NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'Technical Staff', 'PuRD', 1, 'NoImage.png', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(166, 'm.acosta', 'MARIA BELEN SUNGA ACOSTA', 'mabel.acosta@minda.gov.ph', NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'Chairperson', 'OC', 4, 'NoImage.png', NULL, NULL, NULL),
(167, 'r.acosta', 'REY IAN S. ACOSTA', 'reyian.acosta@minda.gov.ph', NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'EA VI', 'OC', 1, 'NoImage.png', NULL, NULL, NULL),
(168, 'l.bulaclac', 'LOU JANE BULACLAC', 'loujane.bulaclac@minda.gov.ph', NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'EA V', 'OC', 1, 'NoImage.png', NULL, NULL, NULL),
(169, 'j.lagarre', 'JULIE MAY LAGARE', 'juliemae.lagare@minda.gov.ph', NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'SAA V', 'OC', 1, 'NoImage.png', NULL, NULL, NULL),
(170, 'e.diano', 'EMMANUEL A. DIANO', 'emmanuel.diano@minda.gov.ph', NULL, '$2y$10$vEXyyFKTCiYaJQNDpbOWvOJ53BvA4TFtUCmkUI9Pxmwnqx./ZncSC', 'AA V', 'OC', 1, 'NoImage.png', NULL, NULL, NULL),
(171, 'joules.rico', 'RICO, JOULES DESPOSADO', 'jolito.rico@minda.gov.ph', NULL, '$2y$10$ga4cxA0uVXmBO3NTxZBwruGxbBL.kp7qa6reHeJXDpz0xIs7ZAAwG', 'Software Programmer', 'OC', 4, 'a5d8b037636471c73e5d60892e66e1d2.jpg', NULL, '2021-02-21 06:15:04', '2021-02-21 06:15:04'),
(172, 'c.trino', 'TRIÑO, CECILIA D', 'cecil.trino@minda.gov.ph', NULL, '$2y$10$fDaxPMXI7l2aqpwhHrnjDeBVywSktOKPqa/ys8so5HhpU4n3wpkxu', 'CAO', 'AD', 2, 'NoImage.png', NULL, '2021-02-21 06:14:58', '2021-02-21 06:14:58'),
(174, 'werewrwe', 'safasdsad', 'sad@dsfsfdsf.cc', NULL, '$2y$10$ewVnhDUORn7SDDGjLo1oguQoqV4azLK5hPbrof5zxsUzfWTsO/j/O', 'sadasdsa', 'OC', 4, 'NoImage.png', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `externals`
--
ALTER TABLE `externals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomings_id_index` (`id`);

--
-- Indexes for table `external_departments`
--
ALTER TABLE `external_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_files`
--
ALTER TABLE `external_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_history`
--
ALTER TABLE `external_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internals`
--
ALTER TABLE `internals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internal_id_index` (`id`);

--
-- Indexes for table `internal_departments`
--
ALTER TABLE `internal_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_files`
--
ALTER TABLE `internal_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_history`
--
ALTER TABLE `internal_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoings`
--
ALTER TABLE `outgoings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `outgoings_id_index` (`id`);

--
-- Indexes for table `outgoing_departments`
--
ALTER TABLE `outgoing_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoing_files`
--
ALTER TABLE `outgoing_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoing_history`
--
ALTER TABLE `outgoing_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pap_codes`
--
ALTER TABLE `pap_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(250));

--
-- Indexes for table `project_counts`
--
ALTER TABLE `project_counts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_number`
--
ALTER TABLE `tracking_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courier`
--
ALTER TABLE `courier`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `externals`
--
ALTER TABLE `externals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `external_departments`
--
ALTER TABLE `external_departments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `external_files`
--
ALTER TABLE `external_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `external_history`
--
ALTER TABLE `external_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internals`
--
ALTER TABLE `internals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `internal_departments`
--
ALTER TABLE `internal_departments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `internal_files`
--
ALTER TABLE `internal_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `internal_history`
--
ALTER TABLE `internal_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `outgoings`
--
ALTER TABLE `outgoings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outgoing_departments`
--
ALTER TABLE `outgoing_departments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outgoing_files`
--
ALTER TABLE `outgoing_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outgoing_history`
--
ALTER TABLE `outgoing_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pap_codes`
--
ALTER TABLE `pap_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `project_counts`
--
ALTER TABLE `project_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tracking_number`
--
ALTER TABLE `tracking_number`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
