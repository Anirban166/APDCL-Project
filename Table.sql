
CREATE TABLE IF NOT EXISTS `registered_users` (
`id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) 
CREATE TABLE IF NOT EXISTS `otp_expiry` (
`id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `create_at` datetime NOT NULL
)
 
