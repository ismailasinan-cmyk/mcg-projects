<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks for clean seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('projects')->truncate();
        DB::table('project_images')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $projects = [
            [
                'id' => 1,
                'name' => 'Construction of Interchange (Flyover) and Bridges for Decongesting Oghor Hill Area, Aba, Abia State',
                'state' => 'Abia',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => '2023-01-05',
                'created_at' => '2026-01-19 11:44:32',
                'updated_at' => '2026-02-03 15:09:30',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 2,
                'name' => 'Reconstruction/Construction of Osusu-Aku-Umunkama (Ugwunagbo) Bridge-Obikabia-Mbaraikoro-Aba-Azumiri Road (12Km), Abia State',
                'state' => 'Abia',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:45:59',
                'updated_at' => '2026-01-19 11:45:59',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 3,
                'name' => 'Construction of 2.8Km Ikot Esidomo-Ikot Esiede Road to The Palace of Itai Afe Annang in Essien Udim LGA with 350m Outfall Drain, Akwa  Ibom State',
                'state' => 'Akwa Ibom',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:46:20',
                'updated_at' => '2026-01-19 11:46:20',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 4,
                'name' => 'Land Clearing and Preparation of Clustered Farmland at Various Locations in Akwa Ibom State',
                'state' => 'Akwa Ibom',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:46:38',
                'updated_at' => '2026-01-19 11:46:38',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 5,
                'name' => 'Construction and Furnishing of   500 bed Space Each for Male and Female Hostel in Bill and Melinda Gates  College of Health Science and Technology, Ningi',
                'state' => 'Bauchi',
                'status' => 'suspended',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:46:55',
                'updated_at' => '2026-01-19 11:46:55',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 6,
                'name' => 'Construction & Equipping of   a 200 Bed Emergency & Trauma Centre and Advanced Diagnostics Centre for   North East Region at Federal Medical Centre, Azare, Bauchi State',
                'state' => 'Bauchi',
                'status' => 'suspended',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:47:11',
                'updated_at' => '2026-01-19 11:47:11',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 7,
                'name' => 'Reconstruction of Failed Portion of Opokuma Road',
                'state' => 'Bayelsa',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:47:41',
                'updated_at' => '2026-01-19 11:47:41',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 8,
                'name' => 'Renovation of Community Primary School Opolo, Bayelsa State',
                'state' => 'Bayelsa',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:47:56',
                'updated_at' => '2026-01-19 11:47:56',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 9,
                'name' => 'Design And Construction Of An Expandable 30,000 Seater  Multi-Purpose Stadium At Igbogene, Yenagoa, Bayelsa State',
                'state' => 'Bayelsa',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:48:24',
                'updated_at' => '2026-01-19 11:48:24',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 10,
                'name' => 'Construction of Concrete  Retaining Walls at Odi Twon for Flood Control',
                'state' => 'Bayelsa',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:48:43',
                'updated_at' => '2026-01-19 11:48:43',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 11,
                'name' => 'Development of Solar Hybrid Power Systems for University of Maiduguri & Teaching Hospital, Borno State under the Energizing Education Programme (EEP) – Phase II',
                'state' => 'Borno',
                'status' => 'operation',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:50:20',
                'updated_at' => '2026-01-19 11:50:20',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 12,
                'name' => 'Supplies of Thirty-Eight Electric Mobilty And Associated Charging Infrastructure in the North-East To NEDC Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:50:47',
                'updated_at' => '2026-01-19 11:50:47',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 13,
                'name' => 'Supplies Of 4,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:51:01',
                'updated_at' => '2026-01-19 11:51:01',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 14,
                'name' => 'Supplies Of 3,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:51:17',
                'updated_at' => '2026-01-19 11:51:17',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 15,
                'name' => 'Supplies Of 3,000 Nos. E-Vehicles (Tricycle), For the North-East Development Commission Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:51:32',
                'updated_at' => '2026-01-19 11:51:32',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 16,
                'name' => 'Supplies Of 100 Nos. BYD Dolphin Ev, 100 Nos. BYD Qin Plus Ev, And 37 Nos BYD Yuan Plus Ev',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:52:14',
                'updated_at' => '2026-01-19 11:52:14',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 17,
                'name' => 'Supplies Of 10 Nos. E-Bus, Fort he North-East Development Commission Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:52:48',
                'updated_at' => '2026-01-19 11:52:48',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 18,
                'name' => 'Supplies Of Charging Infrastructure For E-Vehicles And Other Accessories (Buses, Taxis And Tricycles), For The North-East Development Commission Head Office Maiduguri,  Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:53:15',
                'updated_at' => '2026-01-19 11:53:15',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 19,
                'name' => 'Construction of Charging Infrastructure Point for  E-Vehicles in Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:53:29',
                'updated_at' => '2026-01-19 11:53:29',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 20,
                'name' => 'Supplies of 20 Nos. ANKAI E-BUSES for The NEDC Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:53:43',
                'updated_at' => '2026-01-19 11:53:43',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 21,
                'name' => 'Supplies of 32 Nos. BYD Dolphin EV; 30 Nos. BYD Qin Pl EV for The NEDC Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:53:58',
                'updated_at' => '2026-01-19 11:53:58',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 22,
                'name' => 'Supply and Installation of 2 Nos. of 1.5 Tesla Helium-Free Magnetic Resonance Imaging (MRI) Systems and Training of Relevant Staff at Two (2) tertiary Health Institutions in Borno State for The NEDC Head Office Maiduguri, Borno State',
                'state' => 'Borno',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:54:18',
                'updated_at' => '2026-01-19 11:54:18',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 23,
                'name' => 'Infrastructure Development of Power Generation and supply to Calabar Free Zone & Kano Free Zone',
                'state' => 'Cross River',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:54:38',
                'updated_at' => '2026-01-19 11:54:38',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 24,
                'name' => 'Rehabilitation & Resealing of Otu-Jeremi/Okwagbe Road in Ughelli South LGA, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:54:55',
                'updated_at' => '2026-01-19 11:54:55',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 25,
                'name' => 'Rehabilitation and Asphalt Overlay of  Umunede/Otolokpo/Ute-Okpu/Ekuku-Agbor/Ndemili/Obeti/Umutu Road in Ika North East, Ika South, Ndokwa West and Ukuani LGAs, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:55:17',
                'updated_at' => '2026-01-19 11:55:17',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 26,
                'name' => 'Construction of Oviri-Olomu/Egodor Road in Ughlli Sout and Burutu LGAs, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:57:29',
                'updated_at' => '2026-01-19 11:57:29',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 27,
                'name' => 'Rehabilitation/Reconstruction of 6.7Km Length Section of Asaba-Ugbolu Road from Government House Gate to CBN Estate Junction and Pedestrain Walkway Over Anwai River in Oshimili South LGA, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:58:25',
                'updated_at' => '2026-01-19 11:58:25',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 28,
                'name' => 'Rehabilitation/reconstruction of 4.5km Section of Asaba/Ugbolu Road from CBN Estate Junction to Ugbolu, Delta',
                'state' => 'Delta',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:59:20',
                'updated_at' => '2026-01-19 11:59:20',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 29,
                'name' => 'Construction of Faculty of Environmental Science Building at University of Delta, Owa Alero Campus',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 11:59:45',
                'updated_at' => '2026-01-19 11:59:45',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 30,
                'name' => 'Construction of Film Village and Leisure Park in Anwai-Asaba, Oshimili South LGA',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:42:45',
                'updated_at' => '2026-01-19 12:42:45',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 31,
                'name' => 'Construction of Advanced Diagnostic Medical Complex at Owa-Alero in Ika North-East LGA, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:43:16',
                'updated_at' => '2026-01-19 12:43:16',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 32,
                'name' => 'Construction of Mother and Child Centre at Owa-Alero in Ika North-East LGA, Delta State',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:43:33',
                'updated_at' => '2026-01-19 12:43:33',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 33,
                'name' => 'Construction of Osubi Specialist Hospital (OSH), (Main Building), Osubi, Okpe Local Government Area, Delta',
                'state' => 'Delta',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:45:01',
                'updated_at' => '2026-01-19 12:45:01',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 34,
                'name' => 'Additional Concrete Drains in Erosion Prone Sections And Reconstruction of Road Along Umunede Ute-Okpu Road',
                'state' => 'Delta',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:45:26',
                'updated_at' => '2026-01-19 12:45:26',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 35,
                'name' => 'Engineering, Procurement, and Construction of Solar Micro Grid For The University of Benin',
                'state' => 'Edo',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:45:49',
                'updated_at' => '2026-01-19 12:45:49',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 36,
                'name' => 'Construction of Palace Road, Off Upper Mission Road, Benin City, Edo State',
                'state' => 'Edo',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:46:31',
                'updated_at' => '2026-01-19 12:46:31',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 37,
                'name' => 'Construction of 100 Bed Capacity Hospital at Uwessan, Esan Central Local Government Area, Edo State',
                'state' => 'Edo',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:46:45',
                'updated_at' => '2026-01-19 12:46:45',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 38,
                'name' => 'Rehabilitation of Agbado-Ode-Isinbode-Omuo Road (30.2Km)',
                'state' => 'Ekiti',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:47:42',
                'updated_at' => '2026-01-19 12:47:42',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 39,
                'name' => 'Rehabilitation of AWO-EYIO-ESURE-IFAKI ROAD (14.8Km)',
                'state' => 'Ekiti',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:48:00',
                'updated_at' => '2026-01-19 12:48:00',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 40,
                'name' => 'Construction of Perimeter Fence & Other Associated Works in ATV',
                'state' => 'FCT',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:48:26',
                'updated_at' => '2026-01-19 12:48:26',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 10,
                        'image_path' => 'images/projects/1770048299_0.jpg',
                        'caption' => 'ATV Building',
                        'order' => 1,
                        'created_at' => '2026-02-02 16:04:59',
                        'updated_at' => '2026-02-02 16:04:59',
                    ],
                    [
                        'id' => 11,
                        'image_path' => 'images/projects/1770048299_1.jpg',
                        'caption' => 'Green House',
                        'order' => 2,
                        'created_at' => '2026-02-02 16:04:59',
                        'updated_at' => '2026-02-02 16:04:59',
                    ],
                    [
                        'id' => 12,
                        'image_path' => 'images/projects/1770048299_2.jpg',
                        'caption' => 'Walk away',
                        'order' => 3,
                        'created_at' => '2026-02-02 16:04:59',
                        'updated_at' => '2026-02-02 16:04:59',
                    ],
                    [
                        'id' => 13,
                        'image_path' => 'images/projects/1770048299_3.jpg',
                        'caption' => 'Building',
                        'order' => 4,
                        'created_at' => '2026-02-02 16:04:59',
                        'updated_at' => '2026-02-02 16:04:59',
                    ],
                ]
            ],
            [
                'id' => 41,
                'name' => 'Construction of Two Hundred and Ninety-Two (292) Units of   3-Bedroom (Low-Cost Housing) Bungalows',
                'state' => 'FCT',
                'status' => 'ongoing',
                'description' => 'in The Southern Part of Federal Housing Authority Site, Birnin Kebbi Local Government Area, Kebbi State, Under the Federal Government’s Resettlement Scheme for Persons Impacted By  Conflict (RSPIC)',
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:49:44',
                'updated_at' => '2026-01-19 12:49:44',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 42,
                'name' => 'VISION INVEST PROGRESS MEDIA COMPNAY LTD',
                'state' => 'FCT',
                'status' => 'operation',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:52:37',
                'updated_at' => '2026-01-19 12:52:37',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 43,
                'name' => 'Supply & Installation of X-Band Telemetry Tracking and Command and Digital Data Transmission Integrated Station with Associated Works for The Defence Space Administration',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:53:19',
                'updated_at' => '2026-01-19 12:53:19',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 44,
                'name' => 'Development, Launch, Operation and Maintenance Service of One Customized Micro-Optical Satellites with a Resolution of 0.6 Meters',
                'state' => 'FCT',
                'status' => 'operation',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:53:43',
                'updated_at' => '2026-01-19 12:53:43',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 45,
                'name' => 'Purchase of Space Monitoring Equipment',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:54:07',
                'updated_at' => '2026-01-19 12:54:07',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 46,
                'name' => 'Supply and Processing of Satellite Optical/Infrared/Synthetic Aperture Radar Image and Intelligence Analysis Report for North West Operations with Associated Works for the Defence  Administration',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:54:54',
                'updated_at' => '2026-01-19 12:54:54',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 47,
                'name' => 'Equipping of DEO DCS DNPT LABS',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:55:11',
                'updated_at' => '2026-01-19 12:55:11',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 48,
                'name' => 'Procurement of Additional Equipping of Cyber Operations Centre',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:55:33',
                'updated_at' => '2026-01-19 12:55:33',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 49,
                'name' => 'MCG ERP SYSTEM',
                'state' => 'FCT',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:55:51',
                'updated_at' => '2026-01-19 12:55:51',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 14,
                        'image_path' => 'images/projects/1770048361_0.png',
                        'caption' => 'ERP Platform',
                        'order' => 1,
                        'created_at' => '2026-02-02 16:06:01',
                        'updated_at' => '2026-02-02 16:06:01',
                    ],
                    [
                        'id' => 15,
                        'image_path' => 'images/projects/1770048361_1.png',
                        'caption' => 'Login Page',
                        'order' => 2,
                        'created_at' => '2026-02-02 16:06:01',
                        'updated_at' => '2026-02-02 16:06:01',
                    ],
                ]
            ],
            [
                'id' => 50,
                'name' => 'NIG AGRI DEMO CENTER PRJ',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:56:09',
                'updated_at' => '2026-01-19 12:56:09',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 51,
                'name' => 'Supply of One Thousand, Five Hundred Units Bajaj Boxer Motorcycle to Nigeria Prisons Multipurpose Cooperative Society',
                'state' => 'FCT',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:56:22',
                'updated_at' => '2026-01-19 12:56:22',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 52,
                'name' => 'Establishment One Solar Powered Borehole at Gari Uku Village in Malam Madori LGA, Jigawa State',
                'state' => 'Jigawa',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:56:38',
                'updated_at' => '2026-01-19 12:56:38',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 53,
                'name' => 'Development of Solar Hybrid Power Systems for Nigeria Defence Academy Kaduna under the  Energizing Education Programme (EEP) – Phase II',
                'state' => 'Kaduna',
                'status' => 'operation',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:57:06',
                'updated_at' => '2026-01-19 12:57:06',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 16,
                        'image_path' => 'images/projects/1770048764_0.jpg',
                        'caption' => 'Control room',
                        'order' => 1,
                        'created_at' => '2026-02-02 16:12:44',
                        'updated_at' => '2026-02-02 16:12:44',
                    ],
                    [
                        'id' => 17,
                        'image_path' => 'images/projects/1770048764_1.jpg',
                        'caption' => 'Solar Panels',
                        'order' => 2,
                        'created_at' => '2026-02-02 16:12:44',
                        'updated_at' => '2026-02-02 16:12:44',
                    ],
                    [
                        'id' => 18,
                        'image_path' => 'images/projects/1770048764_2.jpg',
                        'caption' => 'Inverter',
                        'order' => 3,
                        'created_at' => '2026-02-02 16:12:44',
                        'updated_at' => '2026-02-02 16:12:44',
                    ],
                    [
                        'id' => 19,
                        'image_path' => 'images/projects/1770048764_3.jpg',
                        'caption' => 'Transformer',
                        'order' => 4,
                        'created_at' => '2026-02-02 16:12:44',
                        'updated_at' => '2026-02-02 16:12:44',
                    ],
                ]
            ],
            [
                'id' => 54,
                'name' => 'Infrastructure Development of Power Generation and supply to Calabar Free Zone & Kano Free Zone',
                'state' => 'Kano',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:57:36',
                'updated_at' => '2026-01-19 12:57:36',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 20,
                        'image_path' => 'images/projects/1770049053_0.jpg',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-02-02 16:17:33',
                        'updated_at' => '2026-02-02 16:17:33',
                    ],
                    [
                        'id' => 21,
                        'image_path' => 'images/projects/1770049053_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-02-02 16:17:33',
                        'updated_at' => '2026-02-02 16:17:33',
                    ],
                    [
                        'id' => 22,
                        'image_path' => 'images/projects/1770049053_2.jpg',
                        'caption' => NULL,
                        'order' => 3,
                        'created_at' => '2026-02-02 16:17:33',
                        'updated_at' => '2026-02-02 16:17:33',
                    ],
                ]
            ],
            [
                'id' => 55,
                'name' => 'Construction of Earth Dam of 13.2m Height with crest length of 820m, 2m Spillway Height and Active Storage Capacity of 2.6 Million Cubic Meter of Water, Bunkure LGA, Kano State',
                'state' => 'Kano',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:57:51',
                'updated_at' => '2026-01-19 12:57:51',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 23,
                        'image_path' => 'images/projects/1770049119_0.jpg',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-02-02 16:18:39',
                        'updated_at' => '2026-02-02 16:18:39',
                    ],
                    [
                        'id' => 24,
                        'image_path' => 'images/projects/1770049119_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-02-02 16:18:39',
                        'updated_at' => '2026-02-02 16:18:39',
                    ],
                    [
                        'id' => 25,
                        'image_path' => 'images/projects/1770049119_2.jpg',
                        'caption' => NULL,
                        'order' => 3,
                        'created_at' => '2026-02-02 16:18:39',
                        'updated_at' => '2026-02-02 16:18:39',
                    ],
                    [
                        'id' => 26,
                        'image_path' => 'images/projects/1770049119_3.jpg',
                        'caption' => NULL,
                        'order' => 4,
                        'created_at' => '2026-02-02 16:18:39',
                        'updated_at' => '2026-02-02 16:18:39',
                    ],
                    [
                        'id' => 27,
                        'image_path' => 'images/projects/1770049119_4.jpg',
                        'caption' => NULL,
                        'order' => 5,
                        'created_at' => '2026-02-02 16:18:39',
                        'updated_at' => '2026-02-02 16:18:39',
                    ],
                ]
            ],
            [
                'id' => 56,
                'name' => 'Construction of 112.24 Km Backlog Maintenance and Rehabilitation Roads in Katsina State NG-KATSINA RAAMP-462666-CW-RFB/Lot 1',
                'state' => 'Katsina',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:58:26',
                'updated_at' => '2026-01-19 12:58:26',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 57,
                'name' => 'Construction of Danja Earth Dam and Access Road',
                'state' => 'Katsina',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:58:45',
                'updated_at' => '2026-01-19 14:46:14',
                'image' => '1768833974_Nigerian port authority.jpg',
                'images' => [
                    [
                        'id' => 5,
                        'image_path' => 'images/projects/1768907623_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-01-20 11:13:43',
                        'updated_at' => '2026-01-20 11:13:43',
                    ],
                    [
                        'id' => 6,
                        'image_path' => 'images/projects/1768907623_2.jpg',
                        'caption' => NULL,
                        'order' => 3,
                        'created_at' => '2026-01-20 11:13:43',
                        'updated_at' => '2026-01-20 11:13:43',
                    ],
                    [
                        'id' => 7,
                        'image_path' => 'images/projects/1768907623_3.jpg',
                        'caption' => NULL,
                        'order' => 4,
                        'created_at' => '2026-01-20 11:13:43',
                        'updated_at' => '2026-01-20 11:13:43',
                    ],
                ]
            ],
            [
                'id' => 58,
                'name' => 'Completion of Zobe Phase 1B Project for Katsina State',
                'state' => 'Katsina',
                'status' => 'ongoing',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:59:10',
                'updated_at' => '2026-01-19 12:59:10',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 28,
                        'image_path' => 'images/projects/1770049198_0.jpg',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-02-02 16:19:58',
                        'updated_at' => '2026-02-02 16:19:58',
                    ],
                    [
                        'id' => 29,
                        'image_path' => 'images/projects/1770049198_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-02-02 16:19:58',
                        'updated_at' => '2026-02-02 16:19:58',
                    ],
                    [
                        'id' => 30,
                        'image_path' => 'images/projects/1770049198_2.jpg',
                        'caption' => NULL,
                        'order' => 3,
                        'created_at' => '2026-02-02 16:19:58',
                        'updated_at' => '2026-02-02 16:19:58',
                    ],
                    [
                        'id' => 31,
                        'image_path' => 'images/projects/1770049198_3.jpg',
                        'caption' => NULL,
                        'order' => 4,
                        'created_at' => '2026-02-02 16:19:58',
                        'updated_at' => '2026-02-02 16:19:58',
                    ],
                ]
            ],
            [
                'id' => 59,
                'name' => 'Construction, Equipping Airfield Facilities at Nigerian Air Force Base Daura',
                'state' => 'Katsina',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:59:30',
                'updated_at' => '2026-01-19 12:59:30',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 60,
                'name' => 'Supply and Processing of Satellite Optical/Infrared/Synthetic Aperture Radar Image and Intelligence Analysis Report for North West Operations with Associated Works for the Defenc  Administration',
                'state' => 'Kebbi',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 12:59:49',
                'updated_at' => '2026-01-19 12:59:49',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 61,
                'name' => 'Repairs of Flood Damaged Giro Bridge, Along Suru to Giro Road and 3 No’s Bridges Along Argungu to Natsini Road, Kebbi State',
                'state' => 'Kebbi',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:00:09',
                'updated_at' => '2026-01-19 13:00:09',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 62,
                'name' => 'Procurement of Utility Boat',
                'state' => 'Kogi',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:00:27',
                'updated_at' => '2026-01-19 13:00:27',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 63,
                'name' => 'Design and Construction of 2Nos. Marine Vessels Pilot Cutters for the Nigerian Ports Authority',
                'state' => 'Lagos',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:00:57',
                'updated_at' => '2026-01-19 13:00:57',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 32,
                        'image_path' => 'images/projects/1770049277_0.jpg',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-02-02 16:21:17',
                        'updated_at' => '2026-02-02 16:21:17',
                    ],
                    [
                        'id' => 33,
                        'image_path' => 'images/projects/1770049277_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-02-02 16:21:17',
                        'updated_at' => '2026-02-02 16:21:17',
                    ],
                    [
                        'id' => 34,
                        'image_path' => 'images/projects/1770049277_2.jpg',
                        'caption' => NULL,
                        'order' => 3,
                        'created_at' => '2026-02-02 16:21:17',
                        'updated_at' => '2026-02-02 16:21:17',
                    ],
                    [
                        'id' => 35,
                        'image_path' => 'images/projects/1770049277_3.jpg',
                        'caption' => NULL,
                        'order' => 4,
                        'created_at' => '2026-02-02 16:21:17',
                        'updated_at' => '2026-02-02 16:21:17',
                    ],
                    [
                        'id' => 36,
                        'image_path' => 'images/projects/1770049277_4.jpg',
                        'caption' => NULL,
                        'order' => 5,
                        'created_at' => '2026-02-02 16:21:17',
                        'updated_at' => '2026-02-02 16:21:17',
                    ],
                ]
            ],
            [
                'id' => 64,
                'name' => 'Design, Construction and Supply of Two (2Nos.) Pilot Cutters for Eastern Ports of Nigerian Ports Authority',
                'state' => 'Lagos',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:01:16',
                'updated_at' => '2026-01-19 13:01:16',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 37,
                        'image_path' => 'images/projects/1770049333_0.jpg',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-02-02 16:22:13',
                        'updated_at' => '2026-02-02 16:22:13',
                    ],
                    [
                        'id' => 38,
                        'image_path' => 'images/projects/1770049333_1.jpg',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-02-02 16:22:13',
                        'updated_at' => '2026-02-02 16:22:13',
                    ],
                ]
            ],
            [
                'id' => 65,
                'name' => 'Construction of Koto Irabo Road Off Akowonjo Road, Alimosho Federal Constituency, Lagos State',
                'state' => 'Lagos',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:01:33',
                'updated_at' => '2026-01-19 13:01:33',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 66,
                'name' => 'Construction of Lagos Giwa Bridge, Lagos State',
                'state' => 'Lagos',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:01:47',
                'updated_at' => '2026-01-19 13:01:47',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 67,
                'name' => 'Donation of Reconstruction of Akilo Road, Ikeja, Lagos State',
                'state' => 'Lagos',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:02:04',
                'updated_at' => '2026-01-19 13:02:04',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 68,
                'name' => 'Construction and Equipping of the Maternity and Neo-Natal Section of General Hospital, Minna, Niger State',
                'state' => 'Niger',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:02:31',
                'updated_at' => '2026-01-19 13:02:31',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 69,
                'name' => 'Provide Truck Leasing and Transportation Services to NRL',
                'state' => 'FCT',
                'status' => 'operation',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:02:49',
                'updated_at' => '2026-01-19 13:02:49',
                'image' => NULL,
                'images' => [
                    [
                        'id' => 8,
                        'image_path' => 'images/projects/1768908556_0.png',
                        'caption' => NULL,
                        'order' => 1,
                        'created_at' => '2026-01-20 11:29:16',
                        'updated_at' => '2026-01-20 11:29:16',
                    ],
                    [
                        'id' => 9,
                        'image_path' => 'images/projects/1768908556_1.png',
                        'caption' => NULL,
                        'order' => 2,
                        'created_at' => '2026-01-20 11:29:16',
                        'updated_at' => '2026-01-20 11:29:16',
                    ],
                ]
            ],
            [
                'id' => 70,
                'name' => 'Reconstruction of igbara oke, Ibuji road in Ifedore LGA, Ondo State',
                'state' => 'Ondo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:03:06',
                'updated_at' => '2026-01-19 13:03:06',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 71,
                'name' => 'Reconstruction of Ibadan (Eleyele Junction)-Akufo Junction Road 10Km Section 1, Limited Reconstruction of Akufo Junction-Eruwa Road 48Km Section2, Oyo State',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:03:25',
                'updated_at' => '2026-01-19 13:03:25',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 72,
                'name' => 'Expansion/Rehabilitation/Reconstruction of Apata-Bembo-Olosun with Spur to Akala Way (5.40Km), Oyo State',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:03:38',
                'updated_at' => '2026-01-19 13:03:38',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 73,
                'name' => 'Dualization of Dugbe-Magazine-Eleyele Road with spurs to Alesinloye, Onireke/Agbarigo, Ibadan (7.4km)',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:03:51',
                'updated_at' => '2026-01-19 13:03:51',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 74,
                'name' => 'Construction of Okeola-Akolu Road, Eruwa, Ibarapa East LGA, Oyo State',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:04:05',
                'updated_at' => '2026-01-19 13:04:05',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 75,
                'name' => 'Dualization of Ilorin Express Junction-Ikoyi-Takie-Palace-Ogbomoso Grammar School Road, Ogbomoso',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:04:17',
                'updated_at' => '2026-01-19 13:04:17',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 76,
                'name' => 'Rehabilitation/Repair of Office Building, Federal School of Surveying, Oyo',
                'state' => 'Oyo',
                'status' => 'completed',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:04:32',
                'updated_at' => '2026-01-19 13:04:32',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 77,
                'name' => 'Construction of 300 Meter Long Atoki River Bridge Port Harcourt Rivers State',
                'state' => 'Rivers',
                'status' => 'suspended',
                'description' => NULL,
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:04:55',
                'updated_at' => '2026-01-19 13:04:55',
                'image' => NULL,
                'images' => [
                ]
            ],
            [
                'id' => 78,
                'name' => 'Supply and Installation of 2 Nos. of 1.5 Tesla Helium-Free Magnetic Resonance Imaging (MRI) Systems and Training of Relevant Staff at Yobe State University Teaching Hospital,',
                'state' => 'Yobe',
                'status' => 'ongoing',
                'description' => 'Damaturu (1) and Federal Medical  Centre, Nguru (1), Yobe State for The NEDC Head Office Maiduguri, Borno State',
                'awarded_at' => null,
                'created_at' => '2026-01-19 13:05:27',
                'updated_at' => '2026-01-19 13:05:27',
                'image' => NULL,
                'images' => [
                ]
            ],
        ];

        foreach ($projects as $projectData) {
            $images = $projectData['images'];
            unset($projectData['images']);

            DB::table('projects')->insert($projectData);

            foreach ($images as $image) {
                $image['project_id'] = $projectData['id'];
                DB::table('project_images')->insert($image);
            }
        }
    }
}
