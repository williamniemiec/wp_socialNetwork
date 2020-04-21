-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.26 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para wp_socialnetwork
CREATE DATABASE IF NOT EXISTS `wp_socialnetwork` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `wp_socialnetwork`;

-- Copiando estrutura para tabela wp_socialnetwork.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.groups: 4 rows
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `id_user`, `title`) VALUES
	(9, 1, 'test2'),
	(10, 1, 'test3'),
	(8, 1, 'test'),
	(11, 2, 'Name1\'s group');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.groups_members
CREATE TABLE IF NOT EXISTS `groups_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.groups_members: 7 rows
/*!40000 ALTER TABLE `groups_members` DISABLE KEYS */;
INSERT INTO `groups_members` (`id`, `id_group`, `id_user`) VALUES
	(11, 11, 2),
	(7, 10, 1),
	(6, 9, 1),
	(5, 8, 1),
	(9, 10, 2),
	(10, 9, 2),
	(19, 11, 1);
/*!40000 ALTER TABLE `groups_members` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `type` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `url` varchar(100) DEFAULT '0',
  `id_group` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.posts: 17 rows
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `id_user`, `date_creation`, `type`, `text`, `url`, `id_group`) VALUES
	(16, 1, '2020-04-15 14:24:22', 'photo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vehicula risus eros, ac vestibulum ex lobortis dignissim. Morbi id dolor cursus, sodales neque feugiat, bibendum felis. In hac habitasse platea dictumst. Aenean dictum suscipit lacus, at pellentesque est euismod eu. Phasellus imperdiet nisi tellus. Pellentesque nec dolor tincidunt, pretium neque ac, hendrerit odio. Curabitur cursus accumsan neque dignissim suscipit. Fusce in pellentesque mauris. Praesent semper rutrum ligula sit amet volutpat. Nulla sagittis commodo volutpat. Phasellus condimentum faucibus ligula, a elementum lacus molestie id. Donec luctus tellus non quam dignissim, in faucibus lectus laoreet. Morbi elementum neque a viverra egestas.', 'b15086c1b8c4493c4f0294fa7134587b.jpeg', 0),
	(17, 1, '2020-04-15 14:24:43', 'photo', 'Donec rutrum iaculis efficitur. Etiam nec orci vitae dolor vestibulum porttitor. Sed ut nisi ac risus convallis efficitur id dapibus metus. Pellentesque et magna porttitor tortor laoreet porta nec ac enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus tristique venenatis euismod. In lacinia metus est, vel aliquet mi pretium sit amet. Integer consequat tellus felis. Vestibulum a sagittis diam. Maecenas malesuada nisi a metus convallis tincidunt. Maecenas enim nunc, pharetra at sem vitae, dapibus consectetur dolor. Sed sed justo convallis, rutrum ligula at, facilisis nibh. Pellentesque pharetra risus ullamcorper pellentesque tristique. Aliquam erat volutpat.', '30291ad2980b3c57db0f0d37f09bfaee.jpeg', 0),
	(20, 1, '2020-04-15 15:19:53', 'text', 'Donec facilisis quis sapien quis vulputate. Praesent accumsan eu diam vitae pulvinar. Nam nisl lacus, volutpat et tortor sit amet, suscipit consequat ligula. Fusce vitae ullamcorper turpis. Vestibulum vel bibendum nibh.', NULL, 0),
	(21, 1, '2020-04-15 15:25:39', 'photo', '', '0ea994ca83be10d699fec72fb3b2241d.jpeg', 0),
	(31, 2, '2020-04-16 20:19:37', 'text', 'This is my group', NULL, 11),
	(30, 1, '2020-04-16 19:08:27', 'text', 'Post inside group', NULL, 10),
	(25, 4, '2020-04-15 15:30:18', 'text', 'Hello!', NULL, 0),
	(32, 1, '2020-04-17 15:19:29', 'text', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque molestie ullamcorper commodo. Cras sit amet semper lectus. Vivamus sit amet enim sed sapien dictum laoreet. Nunc a facilisis nisi. Nulla mollis vitae nulla nec hendrerit. Praesent id ullamcorper mauris. Ut sit amet eros ultrices, vulputate dolor at, facilisis erat. Proin ac libero a sapien tempus vestibulum at quis augue. Donec consectetur pretium neque vel tristique. Duis id condimentum orci. Donec in fringilla magna.', NULL, 11),
	(33, 1, '2020-04-17 15:19:39', 'text', 'Ut non dictum tortor, ac rutrum eros. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed tincidunt egestas lacinia. Etiam malesuada, nisl a volutpat suscipit, massa eros tempus nulla, ac eleifend ligula elit eu eros. Nulla et ante at nunc euismod consectetur. Suspendisse in sapien posuere, feugiat mauris non, maximus orci. Suspendisse potenti. In semper orci vel elit mattis sollicitudin. Proin finibus pellentesque magna non ullamcorper. Nullam et leo ex.', NULL, 11),
	(34, 1, '2020-04-17 15:19:47', 'text', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor. Curabitur in laoreet odio.', NULL, 11),
	(35, 1, '2020-04-17 15:19:53', 'text', 'Nunc vel purus metus. Fusce tincidunt a ligula elementum cursus. Aenean mollis purus mollis metus consectetur, vel rutrum augue vehicula. Nam quis bibendum tortor, sit amet pretium augue. Nam pharetra ac enim eget vestibulum. Suspendisse hendrerit rhoncus tortor, quis facilisis orci dapibus lobortis. Nulla vulputate semper viverra. Aliquam eu quam porttitor, tristique nunc id, cursus nisl. Proin at sem non elit lacinia fermentum ut eu nunc. Aliquam elit sapien, iaculis non nisi ut, hendrerit faucibus risus. Etiam eu dignissim lectus.', NULL, 11),
	(36, 1, '2020-04-17 15:19:57', 'text', 'Vestibulum varius lacinia ligula, a convallis velit molestie a. Cras pellentesque, ex quis posuere tincidunt, augue nibh aliquam ante, non blandit odio ex ut massa. Duis at scelerisque lacus. Quisque in ultricies libero. In tincidunt tortor a pharetra tristique. Mauris commodo sit amet libero vel efficitur. Maecenas neque eros, condimentum nec purus ut, vehicula ullamcorper tortor. Vestibulum ac neque nec urna aliquam imperdiet.', NULL, 11),
	(37, 1, '2020-04-17 15:20:02', 'text', 'Vivamus sit amet justo ut mi vehicula consectetur. Maecenas efficitur tellus eget arcu efficitur aliquet. Curabitur vitae nulla sapien. Praesent malesuada odio at leo ullamcorper, quis faucibus orci euismod. Suspendisse potenti. Vivamus blandit molestie ante at ornare. Nulla quis tellus sapien. Curabitur at mauris a diam lobortis consequat. Nam ut orci vestibulum, imperdiet urna rhoncus, vehicula risus.', NULL, 11),
	(38, 1, '2020-04-17 15:20:11', 'text', 'Nunc ultricies ligula mauris, et dictum odio auctor non. Suspendisse ultricies vel mauris eu ullamcorper. Proin imperdiet, neque in consequat auctor, arcu ligula congue dui, nec maximus justo quam a eros. Phasellus eu mattis metus. Sed pulvinar sapien ut arcu ultricies luctus. Mauris elementum ex tellus, vel placerat lectus ullamcorper in.', NULL, 11),
	(39, 1, '2020-04-17 15:20:18', 'text', 'Praesent ut consequat justo, in fringilla tortor. Mauris nec dui at leo suscipit cursus. Phasellus eu nulla placerat, bibendum velit ut, venenatis justo. Donec at justo leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus laoreet metus nunc, in commodo neque rhoncus tincidunt. Suspendisse mattis odio et egestas fringilla. Curabitur sit amet nunc porttitor, maximus velit quis, molestie metus. Praesent vulputate dapibus odio, eget luctus nulla vehicula ac. Proin convallis mattis felis et consectetur. Cras consequat metus a nisi aliquet luctus. Suspendisse viverra consequat mi, vitae mattis nulla volutpat mattis. Maecenas semper justo pellentesque placerat interdum.', NULL, 11),
	(40, 1, '2020-04-17 15:20:30', 'text', 'Phasellus leo lorem, accumsan lacinia posuere a, tincidunt in orci. Vestibulum non dapibus nulla. Nam rhoncus molestie augue, et iaculis lectus mattis eget. Nam pretium rutrum sapien, et malesuada ex semper venenatis. Quisque ac convallis dui. In pulvinar orci tristique ligula tristique cursus. Suspendisse faucibus sem dignissim consequat lacinia. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam id dui mi. Vivamus ac blandit sapien, ut egestas magna. Aenean ornare rutrum massa, eget auctor lacus pellentesque non. Integer metus neque, auctor a dapibus eu, venenatis eget nisl. Duis eget dictum erat. Aenean vel metus sit amet felis dictum consequat. Phasellus tempor tempor leo, nec sodales tellus tristique id. Aliquam dapibus, lectus sit amet faucibus semper, quam nibh sollicitudin nisl, et commodo tortor ligula eu dolor.', NULL, 11),
	(41, 1, '2020-04-17 15:20:45', 'text', 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed nec nunc dignissim, vulputate urna nec, ullamcorper erat. Ut dapibus imperdiet nibh, at accumsan urna lacinia in. Integer sed lacus pharetra, pretium lectus sit amet, malesuada enim. Integer nulla neque, convallis eget ornare in, euismod nec ante. Aenean leo metus, suscipit et erat et, porta vehicula mi. Morbi at efficitur nulla.', NULL, 11);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.posts_comments
CREATE TABLE IF NOT EXISTS `posts_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.posts_comments: 6 rows
/*!40000 ALTER TABLE `posts_comments` DISABLE KEYS */;
INSERT INTO `posts_comments` (`id`, `id_user`, `id_post`, `date_creation`, `text`) VALUES
	(1, 1, 16, '2020-04-15 18:14:33', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.'),
	(2, 1, 16, '2020-04-15 19:23:55', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.'),
	(3, 1, 16, '2020-04-15 19:26:37', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.'),
	(4, 1, 16, '2020-04-15 20:08:45', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.'),
	(14, 1, 25, '2020-04-15 20:42:16', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.'),
	(16, 1, 31, '2020-04-16 20:57:11', 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudin. Nunc non fermentum ipsum. Mauris euismod diam felis, at interdum diam mollis eu. Fusce lacinia vulputate arcu at commodo. Vivamus eros tortor, pellentesque ut neque vitae, rhoncus tincidunt tortor.');
/*!40000 ALTER TABLE `posts_comments` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.posts_likes
CREATE TABLE IF NOT EXISTS `posts_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.posts_likes: 4 rows
/*!40000 ALTER TABLE `posts_likes` DISABLE KEYS */;
INSERT INTO `posts_likes` (`id`, `id_user`, `id_post`) VALUES
	(19, 1, 16),
	(37, 1, 25),
	(38, 1, 31),
	(42, 1, 41);
/*!40000 ALTER TABLE `posts_likes` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.relationships
CREATE TABLE IF NOT EXISTS `relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela wp_socialnetwork.relationships: 6 rows
/*!40000 ALTER TABLE `relationships` DISABLE KEYS */;
INSERT INTO `relationships` (`id`, `user_from`, `user_to`, `status`) VALUES
	(16, 1, 2, 0),
	(15, 2, 3, 0),
	(14, 1, 3, 0),
	(12, 2, 4, 1),
	(5, 1, 5, 1),
	(8, 1, 4, 1);
/*!40000 ALTER TABLE `relationships` ENABLE KEYS */;

-- Copiando estrutura para tabela wp_socialnetwork.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `genre` tinyint(1) NOT NULL DEFAULT '0',
  `bio` text,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='password:12345';

-- Copiando dados para a tabela wp_socialnetwork.users: 5 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `genre`, `bio`, `email`, `password`) VALUES
	(1, 'William', 1, 'Sed in facilisis ipsum, tristique hendrerit metus. Donec vel cursus elit, non commodo nisl. Aliquam vulputate arcu id enim sodales sollicitudiin.', 'william@test.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(2, 'Name1', 1, 'Integer ultrices lacus velit, id hendrerit orci condimentum quis. Duis magna risus, pharetra quis sollicitudin eget, vulputate in felis. Nulla eget volutpat ligula, eu porttitor nulla. Integer scelerisque ante varius enim vehicula efficitur. Nunc ornare porta ipsum nec hendrerit. Fusce eget dolor id justo auctor fringilla ut eu dolor. Aliquam tristique massa id varius rhoncus. Proin blandit sed leo nec convallis. Nulla facilisi. Ut mattis tempus tempus. Pellentesque malesuada, risus sed fringilla euismod, purus elit maximus arcu, eu dignissim magna felis a lacus.', 'name1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(3, 'Name2', 0, 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque molestie ullamcorper commodo. Cras sit amet semper lectus. Vivamus sit amet enim sed sapien dictum laoreet. Nunc a facilisis nisi.', 'name2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(4, 'Name3', 1, 'Mauris placerat massa turpis, ac tincidunt neque lacinia quis. Donec eu massa sit amet ipsum pulvinar ullamcorper non quis tortor. Curabitur eu posuere ipsum.', 'name3@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
	(5, 'Name4', 0, 'Sed condimentum orci eu tellus faucibus fringilla.', 'name4@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
