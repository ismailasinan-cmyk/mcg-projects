-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: mcg_projects
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (10,1,'update','App\\Models\\Project',1,'{\"awarded_at\":\"2023-01-05 00:00:00\",\"updated_at\":\"2026-02-03 15:09:30\"}','Updated project: Construction of Interchange (Flyover) and Bridges for Decongesting Oghor Hill Area, Aba, Abia State','127.0.0.1','2026-02-03 14:09:30','2026-02-03 14:09:30'),(11,1,'create','App\\Models\\Project',173,NULL,'Created project: kkf','127.0.0.1','2026-02-04 09:25:56','2026-02-04 09:25:56'),(12,1,'delete','App\\Models\\Project',173,'{\"id\":173,\"name\":\"kkf\",\"state\":\"Adamawa\",\"status\":\"ongoing\",\"awarded_at\":\"2026-02-06T00:00:00.000000Z\",\"description\":null,\"image\":null,\"created_at\":\"2026-02-04T10:25:56.000000Z\",\"updated_at\":\"2026-02-04T10:25:56.000000Z\",\"images\":[{\"id\":55,\"project_id\":173,\"image_path\":\"images\\/projects\\/PJibDaurpOPBV9c5CfwXrzdUvdpRNM2MGg820h8D.png\",\"caption\":null,\"order\":0,\"created_at\":\"2026-02-04T10:25:56.000000Z\",\"updated_at\":\"2026-02-04T10:25:56.000000Z\"},{\"id\":56,\"project_id\":173,\"image_path\":\"images\\/projects\\/s3htxiZYPvHe1io6nTrfOK3Amnz9JN5p2cDOzk0y.png\",\"caption\":null,\"order\":1,\"created_at\":\"2026-02-04T10:25:56.000000Z\",\"updated_at\":\"2026-02-04T10:25:56.000000Z\"}]}','Deleted project: kkf','127.0.0.1','2026-02-04 09:29:08','2026-02-04 09:29:08');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_17_091804_create_projects_table',1),(5,'2026_01_19_141905_create_project_images_table',2),(6,'2026_01_20_101958_create_project_trackings_table',3),(7,'2026_01_20_102116_create_tracking_documents_table',3),(8,'2026_01_20_105938_update_project_trackings_status_column',4),(9,'2026_01_20_142146_rename_location_to_state_in_project_trackings',5),(10,'2026_01_22_185508_add_country_and_lga_to_project_trackings_table',6),(11,'2026_01_22_191225_add_google_id_to_users_table',7),(12,'2026_02_02_163854_create_personal_access_tokens_table',8),(13,'2026_02_03_140306_create_activity_logs_table',9),(14,'2026_02_03_140756_add_role_to_users_table',9),(15,'2026_02_03_145735_add_awarded_year_to_projects_table',10),(16,'2026_02_03_150406_change_awarded_year_to_date_in_projects_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_images`
--

DROP TABLE IF EXISTS `project_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_images_project_id_foreign` (`project_id`),
  CONSTRAINT `project_images_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_images`
--

LOCK TABLES `project_images` WRITE;
/*!40000 ALTER TABLE `project_images` DISABLE KEYS */;
INSERT INTO `project_images` VALUES (5,57,'images/projects/1768907623_1.jpg',NULL,2,'2026-01-20 10:13:43','2026-01-20 10:13:43'),(6,57,'images/projects/1768907623_2.jpg',NULL,3,'2026-01-20 10:13:43','2026-01-20 10:13:43'),(7,57,'images/projects/1768907623_3.jpg',NULL,4,'2026-01-20 10:13:43','2026-01-20 10:13:43'),(8,69,'images/projects/1768908556_0.png',NULL,1,'2026-01-20 10:29:16','2026-01-20 10:29:16'),(9,69,'images/projects/1768908556_1.png',NULL,2,'2026-01-20 10:29:16','2026-01-20 10:29:16'),(10,40,'images/projects/1770048299_0.jpg','ATV Building',1,'2026-02-02 15:04:59','2026-02-02 15:04:59'),(11,40,'images/projects/1770048299_1.jpg','Green House',2,'2026-02-02 15:04:59','2026-02-02 15:04:59'),(12,40,'images/projects/1770048299_2.jpg','Walk away',3,'2026-02-02 15:04:59','2026-02-02 15:04:59'),(13,40,'images/projects/1770048299_3.jpg','Building',4,'2026-02-02 15:04:59','2026-02-02 15:04:59'),(14,49,'images/projects/1770048361_0.png','ERP Platform',1,'2026-02-02 15:06:01','2026-02-02 15:06:01'),(15,49,'images/projects/1770048361_1.png','Login Page',2,'2026-02-02 15:06:01','2026-02-02 15:06:01'),(16,53,'images/projects/1770048764_0.jpg','Control room',1,'2026-02-02 15:12:44','2026-02-02 15:12:44'),(17,53,'images/projects/1770048764_1.jpg','Solar Panels',2,'2026-02-02 15:12:44','2026-02-02 15:12:44'),(18,53,'images/projects/1770048764_2.jpg','Inverter',3,'2026-02-02 15:12:44','2026-02-02 15:12:44'),(19,53,'images/projects/1770048764_3.jpg','Transformer',4,'2026-02-02 15:12:44','2026-02-02 15:12:44'),(20,54,'images/projects/1770049053_0.jpg',NULL,1,'2026-02-02 15:17:33','2026-02-02 15:17:33'),(21,54,'images/projects/1770049053_1.jpg',NULL,2,'2026-02-02 15:17:33','2026-02-02 15:17:33'),(22,54,'images/projects/1770049053_2.jpg',NULL,3,'2026-02-02 15:17:33','2026-02-02 15:17:33'),(23,55,'images/projects/1770049119_0.jpg',NULL,1,'2026-02-02 15:18:39','2026-02-02 15:18:39'),(24,55,'images/projects/1770049119_1.jpg',NULL,2,'2026-02-02 15:18:39','2026-02-02 15:18:39'),(25,55,'images/projects/1770049119_2.jpg',NULL,3,'2026-02-02 15:18:39','2026-02-02 15:18:39'),(26,55,'images/projects/1770049119_3.jpg',NULL,4,'2026-02-02 15:18:39','2026-02-02 15:18:39'),(27,55,'images/projects/1770049119_4.jpg',NULL,5,'2026-02-02 15:18:39','2026-02-02 15:18:39'),(28,58,'images/projects/1770049198_0.jpg',NULL,1,'2026-02-02 15:19:58','2026-02-02 15:19:58'),(29,58,'images/projects/1770049198_1.jpg',NULL,2,'2026-02-02 15:19:58','2026-02-02 15:19:58'),(30,58,'images/projects/1770049198_2.jpg',NULL,3,'2026-02-02 15:19:58','2026-02-02 15:19:58'),(31,58,'images/projects/1770049198_3.jpg',NULL,4,'2026-02-02 15:19:58','2026-02-02 15:19:58'),(32,63,'images/projects/1770049277_0.jpg',NULL,1,'2026-02-02 15:21:17','2026-02-02 15:21:17'),(33,63,'images/projects/1770049277_1.jpg',NULL,2,'2026-02-02 15:21:17','2026-02-02 15:21:17'),(34,63,'images/projects/1770049277_2.jpg',NULL,3,'2026-02-02 15:21:17','2026-02-02 15:21:17'),(35,63,'images/projects/1770049277_3.jpg',NULL,4,'2026-02-02 15:21:17','2026-02-02 15:21:17'),(36,63,'images/projects/1770049277_4.jpg',NULL,5,'2026-02-02 15:21:17','2026-02-02 15:21:17'),(37,64,'images/projects/1770049333_0.jpg',NULL,1,'2026-02-02 15:22:13','2026-02-02 15:22:13'),(38,64,'images/projects/1770049333_1.jpg',NULL,2,'2026-02-02 15:22:13','2026-02-02 15:22:13');
/*!40000 ALTER TABLE `project_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_trackings`
--

DROP TABLE IF EXISTS `project_trackings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_trackings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `company` varchar(255) NOT NULL DEFAULT 'MCC',
  `client` varchar(255) NOT NULL,
  `project` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `lga` varchar(255) DEFAULT NULL,
  `cost` decimal(20,2) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `progress` text DEFAULT NULL,
  `responsible` varchar(255) DEFAULT NULL,
  `status` enum('moving_forward','in_progress','no_progress') NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_trackings`
--

LOCK TABLES `project_trackings` WRITE;
/*!40000 ALTER TABLE `project_trackings` DISABLE KEYS */;
INSERT INTO `project_trackings` VALUES (6,'2024-08-26','MCC','Federal Ministry of Water Resources and Sanitation','construction of Dasin Hausa Dam','Nigeria','Adamawa','Fufure',NULL,'i. EOI submitted\r\nii. Invitation for discussion on MCC model','Awaiting detail design from project consultant','Mr. Ibrahim Usman Imam','moving_forward','2026-01-20 13:38:20','2026-01-23 10:22:24'),(7,'2025-02-20','MCC','UNICEF','Construction of Solar power for health facilities','Nigeria','FCT','Municipal Area Council',NULL,'Discussion on possible ways in colloboration on project','Awaiting response from the Sports Commisssion','Dr. Nasir Usman Imam','in_progress','2026-01-20 13:40:48','2026-01-23 10:21:44'),(8,'2025-02-21','MCC','\"National Sports Commission -  Federal Ministry of Sports Development\"','Rehabilitation of the national stadium, Abuja','Nigeria','FCT','Municipal Area Council',NULL,'Expression of interest and request for audience on the rehabilitation of the national stadium submitted','Awaiting response from the Sports Commisssion','Dr. Nasir Usman Imam','no_progress','2026-01-20 13:42:22','2026-01-23 10:21:59');
/*!40000 ALTER TABLE `project_trackings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `awarded_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Construction of Interchange (Flyover) and Bridges for Decongesting Oghor Hill Area, Aba, Abia State','Abia','completed','2023-01-05',NULL,NULL,'2026-01-19 10:44:32','2026-02-03 14:09:30'),(2,'Reconstruction/Construction of Osusu-Aku-Umunkama (Ugwunagbo) Bridge-Obikabia-Mbaraikoro-Aba-Azumiri Road (12Km), Abia State','Abia','completed',NULL,NULL,NULL,'2026-01-19 10:45:59','2026-01-19 10:45:59'),(3,'Construction of 2.8Km Ikot Esidomo-Ikot Esiede Road to The Palace of Itai Afe Annang in Essien Udim LGA with 350m Outfall Drain, Akwa  Ibom State','Akwa Ibom','completed',NULL,NULL,NULL,'2026-01-19 10:46:20','2026-01-19 10:46:20'),(4,'Land Clearing and Preparation of Clustered Farmland at Various Locations in Akwa Ibom State','Akwa Ibom','completed',NULL,NULL,NULL,'2026-01-19 10:46:38','2026-01-19 10:46:38'),(5,'Construction and Furnishing of   500 bed Space Each for Male and Female Hostel in Bill and Melinda Gates  College of Health Science and Technology, Ningi','Bauchi','suspended',NULL,NULL,NULL,'2026-01-19 10:46:55','2026-01-19 10:46:55'),(6,'Construction & Equipping of   a 200 Bed Emergency & Trauma Centre and Advanced Diagnostics Centre for   North East Region at Federal Medical Centre, Azare, Bauchi State','Bauchi','suspended',NULL,NULL,NULL,'2026-01-19 10:47:11','2026-01-19 10:47:11'),(7,'Reconstruction of Failed Portion of Opokuma Road','Bayelsa','completed',NULL,NULL,NULL,'2026-01-19 10:47:41','2026-01-19 10:47:41'),(8,'Renovation of Community Primary School Opolo, Bayelsa State','Bayelsa','completed',NULL,NULL,NULL,'2026-01-19 10:47:56','2026-01-19 10:47:56'),(9,'Design And Construction Of An Expandable 30,000 Seater  Multi-Purpose Stadium At Igbogene, Yenagoa, Bayelsa State','Bayelsa','ongoing',NULL,NULL,NULL,'2026-01-19 10:48:24','2026-01-19 10:48:24'),(10,'Construction of Concrete  Retaining Walls at Odi Twon for Flood Control','Bayelsa','ongoing',NULL,NULL,NULL,'2026-01-19 10:48:43','2026-01-19 10:48:43'),(11,'Development of Solar Hybrid Power Systems for University of Maiduguri & Teaching Hospital, Borno State under the Energizing Education Programme (EEP) – Phase II','Borno','operation',NULL,NULL,NULL,'2026-01-19 10:50:20','2026-01-19 10:50:20'),(12,'Supplies of Thirty-Eight Electric Mobilty And Associated Charging Infrastructure in the North-East To NEDC Head Office Maiduguri, Borno State','Borno','completed',NULL,NULL,NULL,'2026-01-19 10:50:47','2026-01-19 10:50:47'),(13,'Supplies Of 4,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:51:01','2026-01-19 10:51:01'),(14,'Supplies Of 3,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:51:17','2026-01-19 10:51:17'),(15,'Supplies Of 3,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:51:32','2026-01-19 10:51:32'),(16,'Supplies Of 100 Nos. BYD Dolphin Ev, 100 Nos. BYD Qin Plus Ev, And 37 Nos BYD Yuan Plus Ev','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:52:14','2026-01-19 10:52:14'),(17,'Supplies Of 10 Nos. E-Bus, Fort he North-East Development Commission Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:52:48','2026-01-19 10:52:48'),(18,'Supplies Of Charging Infrastructure For E-Vehicles And Other Accessories (Buses, Taxis And Tricycles), For The North-East Development Commission Head Office Maiduguri,  Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:53:15','2026-01-19 10:53:15'),(19,'Construction of Charging Infrastructure Point for  E-Vehicles in Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:53:29','2026-01-19 10:53:29'),(20,'Supplies of 20 Nos. ANKAI E-BUSES for The NEDC Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:53:43','2026-01-19 10:53:43'),(21,'Supplies of 32 Nos. BYD Dolphin EV; 30 Nos. BYD Qin Pl EV for The NEDC Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:53:58','2026-01-19 10:53:58'),(22,'Supply and Installation of 2 Nos. of 1.5 Tesla Helium-Free Magnetic Resonance Imaging (MRI) Systems and Training of Relevant Staff at Two (2) tertiary Health Institutions in Borno State for The NEDC Head Office Maiduguri, Borno State','Borno','ongoing',NULL,NULL,NULL,'2026-01-19 10:54:18','2026-01-19 10:54:18'),(23,'Infrastructure Development of Power Generation and supply to Calabar Free Zone & Kano Free Zone','Cross River','ongoing',NULL,NULL,NULL,'2026-01-19 10:54:38','2026-01-19 10:54:38'),(24,'Rehabilitation & Resealing of Otu-Jeremi/Okwagbe Road in Ughelli South LGA, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 10:54:55','2026-01-19 10:54:55'),(25,'Rehabilitation and Asphalt Overlay of  Umunede/Otolokpo/Ute-Okpu/Ekuku-Agbor/Ndemili/Obeti/Umutu Road in Ika North East, Ika South, Ndokwa West and Ukuani LGAs, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 10:55:17','2026-01-19 10:55:17'),(26,'Construction of Oviri-Olomu/Egodor Road in Ughlli Sout and Burutu LGAs, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 10:57:29','2026-01-19 10:57:29'),(27,'Rehabilitation/Reconstruction of 6.7Km Length Section of Asaba-Ugbolu Road from Government House Gate to CBN Estate Junction and Pedestrain Walkway Over Anwai River in Oshimili South LGA, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 10:58:25','2026-01-19 10:58:25'),(28,'Rehabilitation/reconstruction of 4.5km Section of Asaba/Ugbolu Road from CBN Estate Junction to Ugbolu, Delta','Delta','ongoing',NULL,NULL,NULL,'2026-01-19 10:59:20','2026-01-19 10:59:20'),(29,'Construction of Faculty of Environmental Science Building at University of Delta, Owa Alero Campus','Delta','completed',NULL,NULL,NULL,'2026-01-19 10:59:45','2026-01-19 10:59:45'),(30,'Construction of Film Village and Leisure Park in Anwai-Asaba, Oshimili South LGA','Delta','completed',NULL,NULL,NULL,'2026-01-19 11:42:45','2026-01-19 11:42:45'),(31,'Construction of Advanced Diagnostic Medical Complex at Owa-Alero in Ika North-East LGA, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 11:43:16','2026-01-19 11:43:16'),(32,'Construction of Mother and Child Centre at Owa-Alero in Ika North-East LGA, Delta State','Delta','completed',NULL,NULL,NULL,'2026-01-19 11:43:33','2026-01-19 11:43:33'),(33,'Construction of Osubi Specialist Hospital (OSH), (Main Building), Osubi, Okpe Local Government Area, Delta','Delta','ongoing',NULL,NULL,NULL,'2026-01-19 11:45:01','2026-01-19 11:45:01'),(34,'Additional Concrete Drains in Erosion Prone Sections And Reconstruction of Road Along Umunede Ute-Okpu Road','Delta','completed',NULL,NULL,NULL,'2026-01-19 11:45:26','2026-01-19 11:45:26'),(35,'Engineering, Procurement, and Construction of Solar Micro Grid For The University of Benin','Edo','ongoing',NULL,NULL,NULL,'2026-01-19 11:45:49','2026-01-19 11:45:49'),(36,'Construction of Palace Road, Off Upper Mission Road, Benin City, Edo State','Edo','ongoing',NULL,NULL,NULL,'2026-01-19 11:46:31','2026-01-19 11:46:31'),(37,'Construction of 100 Bed Capacity Hospital at Uwessan, Esan Central Local Government Area, Edo State','Edo','ongoing',NULL,NULL,NULL,'2026-01-19 11:46:45','2026-01-19 11:46:45'),(38,'Rehabilitation of Agbado-Ode-Isinbode-Omuo Road (30.2Km)','Ekiti','completed',NULL,NULL,NULL,'2026-01-19 11:47:42','2026-01-19 11:47:42'),(39,'Rehabilitation of AWO-EYIO-ESURE-IFAKI ROAD (14.8Km)','Ekiti','completed',NULL,NULL,NULL,'2026-01-19 11:48:00','2026-01-19 11:48:00'),(40,'Construction of Perimeter Fence & Other Associated Works in ATV','FCT','ongoing',NULL,NULL,NULL,'2026-01-19 11:48:26','2026-01-19 11:48:26'),(41,'Construction of Two Hundred and Ninety-Two (292) Units of   3-Bedroom (Low-Cost Housing) Bungalows','FCT','ongoing',NULL,'in The Southern Part of Federal Housing Authority Site, Birnin Kebbi Local Government Area, Kebbi State, Under the Federal Government’s Resettlement Scheme for Persons Impacted By  Conflict (RSPIC)',NULL,'2026-01-19 11:49:44','2026-01-19 11:49:44'),(42,'VISION INVEST PROGRESS MEDIA COMPNAY LTD','FCT','operation',NULL,NULL,NULL,'2026-01-19 11:52:37','2026-01-19 11:52:37'),(43,'Supply & Installation of X-Band Telemetry Tracking and Command and Digital Data Transmission Integrated Station with Associated Works for The Defence Space Administration','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:53:19','2026-01-19 11:53:19'),(44,'Development, Launch, Operation and Maintenance Service of One Customized Micro-Optical Satellites with a Resolution of 0.6 Meters','FCT','operation',NULL,NULL,NULL,'2026-01-19 11:53:43','2026-01-19 11:53:43'),(45,'Purchase of Space Monitoring Equipment','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:54:07','2026-01-19 11:54:07'),(46,'Supply and Processing of Satellite Optical/Infrared/Synthetic Aperture Radar Image and Intelligence Analysis Report for North West Operations with Associated Works for the Defence  Administration','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:54:54','2026-01-19 11:54:54'),(47,'Equipping of DEO DCS DNPT LABS','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:55:11','2026-01-19 11:55:11'),(48,'Procurement of Additional Equipping of Cyber Operations Centre','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:55:33','2026-01-19 11:55:33'),(49,'MCG ERP SYSTEM','FCT','ongoing',NULL,NULL,NULL,'2026-01-19 11:55:51','2026-01-19 11:55:51'),(50,'NIG AGRI DEMO CENTER PRJ','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:56:09','2026-01-19 11:56:09'),(51,'Supply of One Thousand, Five Hundred Units Bajaj Boxer Motorcycle to Nigeria Prisons Multipurpose Cooperative Society','FCT','completed',NULL,NULL,NULL,'2026-01-19 11:56:22','2026-01-19 11:56:22'),(52,'Establishment One Solar Powered Borehole at Gari Uku Village in Malam Madori LGA, Jigawa State','Jigawa','completed',NULL,NULL,NULL,'2026-01-19 11:56:38','2026-01-19 11:56:38'),(53,'Development of Solar Hybrid Power Systems for Nigeria Defence Academy Kaduna under the  Energizing Education Programme (EEP) – Phase II','Kaduna','operation',NULL,NULL,NULL,'2026-01-19 11:57:06','2026-01-19 11:57:06'),(54,'Infrastructure Development of Power Generation and supply to Calabar Free Zone & Kano Free Zone','Kano','ongoing',NULL,NULL,NULL,'2026-01-19 11:57:36','2026-01-19 11:57:36'),(55,'Construction of Earth Dam of 13.2m Height with crest length of 820m, 2m Spillway Height and Active Storage Capacity of 2.6 Million Cubic Meter of Water, Bunkure LGA, Kano State','Kano','completed',NULL,NULL,NULL,'2026-01-19 11:57:51','2026-01-19 11:57:51'),(56,'Construction of 112.24 Km Backlog Maintenance and Rehabilitation Roads in Katsina State NG-KATSINA RAAMP-462666-CW-RFB/Lot 1','Katsina','ongoing',NULL,NULL,NULL,'2026-01-19 11:58:26','2026-01-19 11:58:26'),(57,'Construction of Danja Earth Dam and Access Road','Katsina','completed',NULL,NULL,'1768833974_Nigerian port authority.jpg','2026-01-19 11:58:45','2026-01-19 13:46:14'),(58,'Completion of Zobe Phase 1B Project for Katsina State','Katsina','ongoing',NULL,NULL,NULL,'2026-01-19 11:59:10','2026-01-19 11:59:10'),(59,'Construction, Equipping Airfield Facilities at Nigerian Air Force Base Daura','Katsina','completed',NULL,NULL,NULL,'2026-01-19 11:59:30','2026-01-19 11:59:30'),(60,'Supply and Processing of Satellite Optical/Infrared/Synthetic Aperture Radar Image and Intelligence Analysis Report for North West Operations with Associated Works for the Defenc  Administration','Kebbi','completed',NULL,NULL,NULL,'2026-01-19 11:59:49','2026-01-19 11:59:49'),(61,'Repairs of Flood Damaged Giro Bridge, Along Suru to Giro Road and 3 No’s Bridges Along Argungu to Natsini Road, Kebbi State','Kebbi','completed',NULL,NULL,NULL,'2026-01-19 12:00:09','2026-01-19 12:00:09'),(62,'Procurement of Utility Boat','Kogi','completed',NULL,NULL,NULL,'2026-01-19 12:00:27','2026-01-19 12:00:27'),(63,'Design and Construction of 2Nos. Marine Vessels Pilot Cutters for the Nigerian Ports Authority','Lagos','completed',NULL,NULL,NULL,'2026-01-19 12:00:57','2026-01-19 12:00:57'),(64,'Design, Construction and Supply of Two (2Nos.) Pilot Cutters for Eastern Ports of Nigerian Ports Authority','Lagos','completed',NULL,NULL,NULL,'2026-01-19 12:01:16','2026-01-19 12:01:16'),(65,'Construction of Koto Irabo Road Off Akowonjo Road, Alimosho Federal Constituency, Lagos State','Lagos','completed',NULL,NULL,NULL,'2026-01-19 12:01:33','2026-01-19 12:01:33'),(66,'Construction of Lagos Giwa Bridge, Lagos State','Lagos','completed',NULL,NULL,NULL,'2026-01-19 12:01:47','2026-01-19 12:01:47'),(67,'Donation of Reconstruction of Akilo Road, Ikeja, Lagos State','Lagos','completed',NULL,NULL,NULL,'2026-01-19 12:02:04','2026-01-19 12:02:04'),(68,'Construction and Equipping of the Maternity and Neo-Natal Section of General Hospital, Minna, Niger State','Niger','completed',NULL,NULL,NULL,'2026-01-19 12:02:31','2026-01-19 12:02:31'),(69,'Provide Truck Leasing and Transportation Services to NRL','FCT','operation',NULL,NULL,NULL,'2026-01-19 12:02:49','2026-01-19 12:02:49'),(70,'Reconstruction of igbara oke, Ibuji road in Ifedore LGA, Ondo State','Ondo','completed',NULL,NULL,NULL,'2026-01-19 12:03:06','2026-01-19 12:03:06'),(71,'Reconstruction of Ibadan (Eleyele Junction)-Akufo Junction Road 10Km Section 1, Limited Reconstruction of Akufo Junction-Eruwa Road 48Km Section2, Oyo State','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:03:25','2026-01-19 12:03:25'),(72,'Expansion/Rehabilitation/Reconstruction of Apata-Bembo-Olosun with Spur to Akala Way (5.40Km), Oyo State','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:03:38','2026-01-19 12:03:38'),(73,'Dualization of Dugbe-Magazine-Eleyele Road with spurs to Alesinloye, Onireke/Agbarigo, Ibadan (7.4km)','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:03:51','2026-01-19 12:03:51'),(74,'Construction of Okeola-Akolu Road, Eruwa, Ibarapa East LGA, Oyo State','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:04:05','2026-01-19 12:04:05'),(75,'Dualization of Ilorin Express Junction-Ikoyi-Takie-Palace-Ogbomoso Grammar School Road, Ogbomoso','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:04:17','2026-01-19 12:04:17'),(76,'Rehabilitation/Repair of Office Building, Federal School of Surveying, Oyo','Oyo','completed',NULL,NULL,NULL,'2026-01-19 12:04:32','2026-01-19 12:04:32'),(77,'Construction of 300 Meter Long Atoki River Bridge Port Harcourt Rivers State','Rivers','suspended',NULL,NULL,NULL,'2026-01-19 12:04:55','2026-01-19 12:04:55'),(78,'Supply and Installation of 2 Nos. of 1.5 Tesla Helium-Free Magnetic Resonance Imaging (MRI) Systems and Training of Relevant Staff at Yobe State University Teaching Hospital,','Yobe','ongoing',NULL,'Damaturu (1) and Federal Medical  Centre, Nguru (1), Yobe State for The NEDC Head Office Maiduguri, Borno State',NULL,'2026-01-19 12:05:27','2026-01-19 12:05:27');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tracking_documents`
--

DROP TABLE IF EXISTS `tracking_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracking_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_tracking_id` bigint(20) unsigned NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tracking_documents_project_tracking_id_foreign` (`project_tracking_id`),
  CONSTRAINT `tracking_documents_project_tracking_id_foreign` FOREIGN KEY (`project_tracking_id`) REFERENCES `project_trackings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracking_documents`
--

LOCK TABLES `tracking_documents` WRITE;
/*!40000 ALTER TABLE `tracking_documents` DISABLE KEYS */;
INSERT INTO `tracking_documents` VALUES (6,8,'Cover (1).pdf','documents/tracking/1768920142_696f944e726ca_Cover (1).pdf','pdf','2.80 MB','2026-01-20 13:42:22','2026-01-20 13:42:22');
/*!40000 ALTER TABLE `tracking_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'viewer',
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Idrs Sinan','ismailaidrissinan@gmail.com','viewer',NULL,NULL,'$2y$12$vdD.ZuvuuNuE21z/yJ1PZuEvIVGd1GsUipovHmmMq.N.8Vw6w7irS','DMOTsXbA3zPwBVmqKTO5QKyri26Hi4iVqSkh1TwOEiSmmCV5fVo6fX1CrYFc','2026-01-19 10:42:57','2026-01-19 10:42:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-04 12:48:50
