DROP TABLE IF EXISTS `Utilisateur`;

CREATE TABLE `Utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `tel`varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `date_naissance` varchar(255) DEFAULT NULL,
  `film_favori`  varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
);

LOCK TABLES `Utilisateur` WRITE;
INSERT INTO `Utilisateur`(`id_utilisateur`, `nom`, `mot_de_passe`, `role`, `tel`, `mail`, `date_naissance`, `film_favori`) VALUES (1,'vanier','$2y$10$7iVLbtmdtb.U0Om/AwD3g./kJgLDfe41f3M4yJHVqxbtavwxyVdtW','utilisateur','0606060606','vanier@gmail.com','1990-12-31','Le voyage de Chihiro');
INSERT INTO `Utilisateur`(`id_utilisateur`, `nom`, `mot_de_passe`, `role`, `tel`, `mail`, `date_naissance`, `film_favori`) VALUES (2,'lecarpentier','$2y$10$mDodcigBYQP7eDxVyZtQ8.vcP/6SbW9x39IcV9sO0W2eWgIp5vwvy','utilisateur','0606060606','lecarpentier@gmail.com','1990-12-31','Le voyage de Chihiro');
UNLOCK TABLES;

DROP TABLE IF EXISTS `ProduitGhibli`;
CREATE TABLE `ProduitGhibli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `lien_image` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `creation_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `ProduitGhibli` WRITE;
INSERT INTO `ProduitGhibli`(`id`, `id_utilisateur`, `nom`, `lien_image`, `type`, `creation_date`) VALUES (1,1,"Peluche totoro","https://s1.thcdn.com/productimg/960/960/11117383-1834292479519770.jpg","peluche","2010-05-06");
INSERT INTO `ProduitGhibli`(`id`, `id_utilisateur`, `nom`, `lien_image`, `type`, `creation_date`) VALUES (2,1,"DVD le voyage de Chihiro","https://www.nautiljon.com/images/dvd/00/64/mini/le_voyage_de_chihiro_-_dvd_46.jpg?11465315111","DVD","2002-05-10");
INSERT INTO `ProduitGhibli`(`id`, `id_utilisateur`, `nom`, `lien_image`, `type`, `creation_date`) VALUES (3,2,"Mug ghibli","https://c49d16a6c82563251344-1ab5a5b00ecdd96a368a8d8d17482920.ssl.cf2.rackcdn.com/images/TS_Ghibli_Gang_Black_Handle_Mug_9_99-617-662.jpg","mug","2015-03-09");
INSERT INTO `ProduitGhibli`(`id`, `id_utilisateur`, `nom`, `lien_image`, `type`, `creation_date`) VALUES (4,2,"Kigurumi no face","https://www.4kigurumi.com/image/cache/data/kigurumi/D010/no-face-man-kigurumi-costumes-600x900.jpg","kigurumi","2014-03-17");
UNLOCK TABLES;
