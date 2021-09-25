<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * create 110_insert_applepay_module_setting_table
 */
class Migration_Create_Workout_With_Us_Videos_Table extends CI_Migration { 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_workout_with_us_videos` (
            `workout_with_us_video_id` int(11) NOT NULL AUTO_INCREMENT,
            `workout_video_id` int(11) DEFAULT NULL,
            `image` varchar(111) DEFAULT NULL,
            `title` varchar(255) DEFAULT NULL,
            `description` text DEFAULT NULL,
            `video_url` text DEFAULT NULL,
            `workout_video_module_id` int(11) DEFAULT NULL,
            `workout_video_schedule_id` int(11) DEFAULT NULL,
            `week` int(3) DEFAULT NULL,
            `day` int(3) DEFAULT NULL,
            `sets` int(11) DEFAULT NULL,
            `reps` varchar(51) DEFAULT NULL,
            `filename` varchar(255) DEFAULT NULL,
            `duration` int(11) DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            `is_paid` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`workout_with_us_video_id`)
           ) ENGINE=InnoDB;");


        $this->db->query("INSERT INTO `yvdnsddqu_workout_with_us_videos` (`workout_with_us_video_id`, `workout_video_id`, `image`, `title`, `description`, `video_url`, `workout_video_module_id`, `workout_video_schedule_id`, `week`, `day`, `sets`, `reps`, `filename`, `duration`, `status`, `is_paid`) VALUES
        (NULL, 8,'1627380853_1626668800_wp4646520.jpg', 'Test123 - July 16 Chest - Dumbbell Incline Press', 'Test1 - July 16 Chest - Dumbbell Incline PressJuly 16 Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/545454829?badge=0&autopause=0&player_id=0&app_id=58479', 1, 1, 2, 2, 2, '2', 'video2.mp4', 20, 1, 1),
        (NULL, 8,'1627375467_16.png', 'Test - July 16 Chest - Dumbbell Incline Press', 'Test - July 16 Chest - Dumbbell Incline PressJuly 16 Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/545454829?badge=0&autopause=0&player_id=0&app_id=58479', 1, 1, 1, 1, 1, '1', 'video2.mp4', 10, 1, 1),
        (NULL, 8,'1626423323_51cd3aea2b0852fd4f5e98ac51eb074b.jpg', 'July 16 Chest - Dumbbell Incline Press', 'Testing Chest - Dumbbell **July 16**Incline Press', 'https://player.vimeo.com/video/545454829?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', 4, 6, 3, 3, 30, '6/8', 'video1.mp4', 30, 1, 1),
        (NULL, 8,'1626668800_wp4646520.jpg', 'July 16 Chest - Dumbbell Incline Press', 'Chest - Dumbbell Incline PressJuly 16', 'https://player.vimeo.com/video/545454829?badge=0&autopause=0&player_id=0&app_id=58479', 3, 5, 2, 2, 25, '6/810/15', 'video2.mp4', 20, 0, 1),
        (NULL, 8,'30.png', 'July 16 Chest - Dumbbell Incline Press', 'July 16Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/\n545454829?badge=0&amp;autopause=0&amp;\nplayer_id=0&amp;app_id=58479', 2, 4, 1, 1, 15, '6/8\n10/15\n20/30', 'video3.mp4', 10, 1, 1),
        (NULL, 8,'23.png', '*July15 Chest - Dumbbell Incline Press', 'Testing Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/\n545454829?badge=0&amp;autopause=0&amp;\nplayer_id=0&amp;app_id=58479', 5, 2, 3, 2, 15, '6/8\n10/15\n20/30', 'video1.mp4', 27, 0, 1),
        (NULL, 8,'10.png', '*July15 Chest - Dumbbell Incline Press', 'Testing Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/\n545454829?badge=0&autopause=0&\nplayer_id=0&app_id=58479', 5, 2, 3, 2, 15, '6/8\n10/15', 'video1.mp4', 27, 1, 1),
        (NULL, 8,'1.png', '*July15 Chest - Dumbbell Incline Press', 'Testing Chest - Dumbbell Incline Press', 'https://player.vimeo.com/video/\n545454829?badge=0&amp;autopause=0&amp;\nplayer_id=0&amp;app_id=58479', 5, 2, 3, 2, 15, '6/8', 'video1.mp4', 27, 1, 1),
        (NULL, 8,'12.png', 'Lee_Priest_Promo_1', 'Lee_Priest_Promo_1', 'https://player.vimeo.com/video/565427977?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', 10, 4, 1, 4, 12, '9', 'Lee_Priest_Promo_1.mp4', 10, 1, 0);");

    }    

    public function down() {
        
    }
}

/* End of file 110_insert_applepay_module_setting_table */
/* Location: ./setup/migrations/110_insert_applepay_module_setting_table */