DROP TABLE IF EXISTS `%prefix%material_static`;
CREATE TABLE `%prefix%material_static` (
  `material_id` int(10) NOT NULL,
  `material_name` varchar(255) collate latin1_general_ci default NULL,
  `material_type` tinyint(3) NOT NULL default '0',
  `material_volume` float NOT NULL default '0',
  PRIMARY KEY  (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `pos2_material_static`
-- 

INSERT INTO `%prefix%material_static` VALUES (0, 'None', 0, 0);
INSERT INTO `%prefix%material_static` VALUES (16634, 'Atmospheric Gases', 1, 0.2);
INSERT INTO `%prefix%material_static` VALUES (16643, 'Cadmium', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16647, 'Caesium', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16641, 'Chromium', 1, 0.6);
INSERT INTO `%prefix%material_static` VALUES (16640, 'Cobalt', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16650, 'Dysprosium', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16635, 'Evaporite Deposits', 1, 0.2);
INSERT INTO `%prefix%material_static` VALUES (16648, 'Hafnium', 1, 0.8);
INSERT INTO `%prefix%material_static` VALUES (16633, 'Hydrocarbons', 1, 0.2);
INSERT INTO `%prefix%material_static` VALUES (16646, 'Mercury', 1, 0.8);
INSERT INTO `%prefix%material_static` VALUES (16651, 'Neodymium', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16644, 'Platinum', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16652, 'Promethium', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16639, 'Scandium', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16636, 'Silicates', 1, 0.2);
INSERT INTO `%prefix%material_static` VALUES (16649, 'Technetium', 1, 0.8);
INSERT INTO `%prefix%material_static` VALUES (16653, 'Thulium', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16638, 'Titanium', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16637, 'Tungsten', 1, 0.4);
INSERT INTO `%prefix%material_static` VALUES (16642, 'Vanadium', 1, 1);
INSERT INTO `%prefix%material_static` VALUES (16663, 'Caesarium Cadmide', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16659, 'Carbon Polymers', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16660, 'Ceramic Powder', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16655, 'Crystallite Alloy', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16668, 'Dysporite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16656, 'Fernite Alloy', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16669, 'Ferrofluid', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (17769, 'Fluxed Condensates', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16665, 'Hexite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16666, 'Hyperflurite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16667, 'Neo Mercurite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16662, 'Platinum Technite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (17960, 'Prometium', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16657, 'Rolled Tungsten Alloy', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16658, 'Silicon Diborite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16664, 'Solerium', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16661, 'Sulfuric Acid', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16654, 'Titanium Chromide', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (17959, 'Vanadium Hafnite', 2, 1);
INSERT INTO `%prefix%material_static` VALUES (16670, 'Crystalline Carbonide', 3, 0.05);
INSERT INTO `%prefix%material_static` VALUES (17317, 'Fermionic Condensates', 3, 1.3);
INSERT INTO `%prefix%material_static` VALUES (16673, 'Fernite Carbide', 3, 0.05);
INSERT INTO `%prefix%material_static` VALUES (16683, 'Ferrogel', 3, 1);
INSERT INTO `%prefix%material_static` VALUES (16679, 'Fullerides', 3, 0.15);
INSERT INTO `%prefix%material_static` VALUES (16682, 'Hypersynaptic Fibers', 3, 0.6);
INSERT INTO `%prefix%material_static` VALUES (16681, 'Nanotransistors', 3, 0.25);
INSERT INTO `%prefix%material_static` VALUES (16680, 'Phenolic Composites', 3, 0.2);
INSERT INTO `%prefix%material_static` VALUES (16678, 'Sylramic Fibers', 3, 0.075);
INSERT INTO `%prefix%material_static` VALUES (16671, 'Titanium Carbide', 3, 0.05);
INSERT INTO `%prefix%material_static` VALUES (16672, 'Tungsten Carbide', 3, 0.05);

UPDATE `%prefix%silo_info` SET `material_id` = '16634' WHERE `material_id` =1;
UPDATE `%prefix%silo_info` SET `material_id` = '16643' WHERE `material_id` =2;
UPDATE `%prefix%silo_info` SET `material_id` = '16647' WHERE `material_id` =3;
UPDATE `%prefix%silo_info` SET `material_id` = '16641' WHERE `material_id` =4;
UPDATE `%prefix%silo_info` SET `material_id` = '16640' WHERE `material_id` =5;
UPDATE `%prefix%silo_info` SET `material_id` = '16650' WHERE `material_id` =6;
UPDATE `%prefix%silo_info` SET `material_id` = '16635' WHERE `material_id` =7;
UPDATE `%prefix%silo_info` SET `material_id` = '16648' WHERE `material_id` =8;
UPDATE `%prefix%silo_info` SET `material_id` = '16633' WHERE `material_id` =9;
UPDATE `%prefix%silo_info` SET `material_id` = '16646' WHERE `material_id` =10;
UPDATE `%prefix%silo_info` SET `material_id` = '16651' WHERE `material_id` =11;
UPDATE `%prefix%silo_info` SET `material_id` = '16644' WHERE `material_id` =12;
UPDATE `%prefix%silo_info` SET `material_id` = '16652' WHERE `material_id` =13;
UPDATE `%prefix%silo_info` SET `material_id` = '16639' WHERE `material_id` =14;
UPDATE `%prefix%silo_info` SET `material_id` = '16636' WHERE `material_id` =15;
UPDATE `%prefix%silo_info` SET `material_id` = '16649' WHERE `material_id` =16;
UPDATE `%prefix%silo_info` SET `material_id` = '16653' WHERE `material_id` =17;
UPDATE `%prefix%silo_info` SET `material_id` = '16638' WHERE `material_id` =18;
UPDATE `%prefix%silo_info` SET `material_id` = '16637' WHERE `material_id` =19;
UPDATE `%prefix%silo_info` SET `material_id` = '16642' WHERE `material_id` =20;
UPDATE `%prefix%silo_info` SET `material_id` = '16663' WHERE `material_id` =21;
UPDATE `%prefix%silo_info` SET `material_id` = '16659' WHERE `material_id` =22;
UPDATE `%prefix%silo_info` SET `material_id` = '16660' WHERE `material_id` =23;
UPDATE `%prefix%silo_info` SET `material_id` = '16655' WHERE `material_id` =24;
UPDATE `%prefix%silo_info` SET `material_id` = '16668' WHERE `material_id` =25;
UPDATE `%prefix%silo_info` SET `material_id` = '16656' WHERE `material_id` =26;
UPDATE `%prefix%silo_info` SET `material_id` = '16669' WHERE `material_id` =27;
UPDATE `%prefix%silo_info` SET `material_id` = '17769' WHERE `material_id` =28;
UPDATE `%prefix%silo_info` SET `material_id` = '16665' WHERE `material_id` =29;
UPDATE `%prefix%silo_info` SET `material_id` = '16666' WHERE `material_id` =30;
UPDATE `%prefix%silo_info` SET `material_id` = '16667' WHERE `material_id` =31;
UPDATE `%prefix%silo_info` SET `material_id` = '16662' WHERE `material_id` =32;
UPDATE `%prefix%silo_info` SET `material_id` = '17960' WHERE `material_id` =33;
UPDATE `%prefix%silo_info` SET `material_id` = '16657' WHERE `material_id` =34;
UPDATE `%prefix%silo_info` SET `material_id` = '16658' WHERE `material_id` =35;
UPDATE `%prefix%silo_info` SET `material_id` = '16664' WHERE `material_id` =36;
UPDATE `%prefix%silo_info` SET `material_id` = '16661' WHERE `material_id` =37;
UPDATE `%prefix%silo_info` SET `material_id` = '16654' WHERE `material_id` =38;
UPDATE `%prefix%silo_info` SET `material_id` = '17959' WHERE `material_id` =39;
UPDATE `%prefix%silo_info` SET `material_id` = '16670' WHERE `material_id` =40;
UPDATE `%prefix%silo_info` SET `material_id` = '17317' WHERE `material_id` =41;
UPDATE `%prefix%silo_info` SET `material_id` = '16673' WHERE `material_id` =42;
UPDATE `%prefix%silo_info` SET `material_id` = '16683' WHERE `material_id` =43;
UPDATE `%prefix%silo_info` SET `material_id` = '16679' WHERE `material_id` =44;
UPDATE `%prefix%silo_info` SET `material_id` = '16682' WHERE `material_id` =45;
UPDATE `%prefix%silo_info` SET `material_id` = '16681' WHERE `material_id` =46;
UPDATE `%prefix%silo_info` SET `material_id` = '16680' WHERE `material_id` =47;
UPDATE `%prefix%silo_info` SET `material_id` = '16678' WHERE `material_id` =48;
UPDATE `%prefix%silo_info` SET `material_id` = '16671' WHERE `material_id` =49;
UPDATE `%prefix%silo_info` SET `material_id` = '16672' WHERE `material_id` =50;




UPDATE `%prefix%reactor_info` SET `material_id` = '16634' WHERE `material_id` =1;
UPDATE `%prefix%reactor_info` SET `material_id` = '16643' WHERE `material_id` =2;
UPDATE `%prefix%reactor_info` SET `material_id` = '16647' WHERE `material_id` =3;
UPDATE `%prefix%reactor_info` SET `material_id` = '16641' WHERE `material_id` =4;
UPDATE `%prefix%reactor_info` SET `material_id` = '16640' WHERE `material_id` =5;
UPDATE `%prefix%reactor_info` SET `material_id` = '16650' WHERE `material_id` =6;
UPDATE `%prefix%reactor_info` SET `material_id` = '16635' WHERE `material_id` =7;
UPDATE `%prefix%reactor_info` SET `material_id` = '16648' WHERE `material_id` =8;
UPDATE `%prefix%reactor_info` SET `material_id` = '16633' WHERE `material_id` =9;
UPDATE `%prefix%reactor_info` SET `material_id` = '16646' WHERE `material_id` =10;
UPDATE `%prefix%reactor_info` SET `material_id` = '16651' WHERE `material_id` =11;
UPDATE `%prefix%reactor_info` SET `material_id` = '16644' WHERE `material_id` =12;
UPDATE `%prefix%reactor_info` SET `material_id` = '16652' WHERE `material_id` =13;
UPDATE `%prefix%reactor_info` SET `material_id` = '16639' WHERE `material_id` =14;
UPDATE `%prefix%reactor_info` SET `material_id` = '16636' WHERE `material_id` =15;
UPDATE `%prefix%reactor_info` SET `material_id` = '16649' WHERE `material_id` =16;
UPDATE `%prefix%reactor_info` SET `material_id` = '16653' WHERE `material_id` =17;
UPDATE `%prefix%reactor_info` SET `material_id` = '16638' WHERE `material_id` =18;
UPDATE `%prefix%reactor_info` SET `material_id` = '16637' WHERE `material_id` =19;
UPDATE `%prefix%reactor_info` SET `material_id` = '16642' WHERE `material_id` =20;
UPDATE `%prefix%reactor_info` SET `material_id` = '16663' WHERE `material_id` =21;
UPDATE `%prefix%reactor_info` SET `material_id` = '16659' WHERE `material_id` =22;
UPDATE `%prefix%reactor_info` SET `material_id` = '16660' WHERE `material_id` =23;
UPDATE `%prefix%reactor_info` SET `material_id` = '16655' WHERE `material_id` =24;
UPDATE `%prefix%reactor_info` SET `material_id` = '16668' WHERE `material_id` =25;
UPDATE `%prefix%reactor_info` SET `material_id` = '16656' WHERE `material_id` =26;
UPDATE `%prefix%reactor_info` SET `material_id` = '16669' WHERE `material_id` =27;
UPDATE `%prefix%reactor_info` SET `material_id` = '17769' WHERE `material_id` =28;
UPDATE `%prefix%reactor_info` SET `material_id` = '16665' WHERE `material_id` =29;
UPDATE `%prefix%reactor_info` SET `material_id` = '16666' WHERE `material_id` =30;
UPDATE `%prefix%reactor_info` SET `material_id` = '16667' WHERE `material_id` =31;
UPDATE `%prefix%reactor_info` SET `material_id` = '16662' WHERE `material_id` =32;
UPDATE `%prefix%reactor_info` SET `material_id` = '17960' WHERE `material_id` =33;
UPDATE `%prefix%reactor_info` SET `material_id` = '16657' WHERE `material_id` =34;
UPDATE `%prefix%reactor_info` SET `material_id` = '16658' WHERE `material_id` =35;
UPDATE `%prefix%reactor_info` SET `material_id` = '16664' WHERE `material_id` =36;
UPDATE `%prefix%reactor_info` SET `material_id` = '16661' WHERE `material_id` =37;
UPDATE `%prefix%reactor_info` SET `material_id` = '16654' WHERE `material_id` =38;
UPDATE `%prefix%reactor_info` SET `material_id` = '17959' WHERE `material_id` =39;
UPDATE `%prefix%reactor_info` SET `material_id` = '16670' WHERE `material_id` =40;
UPDATE `%prefix%reactor_info` SET `material_id` = '17317' WHERE `material_id` =41;
UPDATE `%prefix%reactor_info` SET `material_id` = '16673' WHERE `material_id` =42;
UPDATE `%prefix%reactor_info` SET `material_id` = '16683' WHERE `material_id` =43;
UPDATE `%prefix%reactor_info` SET `material_id` = '16679' WHERE `material_id` =44;
UPDATE `%prefix%reactor_info` SET `material_id` = '16682' WHERE `material_id` =45;
UPDATE `%prefix%reactor_info` SET `material_id` = '16681' WHERE `material_id` =46;
UPDATE `%prefix%reactor_info` SET `material_id` = '16680' WHERE `material_id` =47;
UPDATE `%prefix%reactor_info` SET `material_id` = '16678' WHERE `material_id` =48;
UPDATE `%prefix%reactor_info` SET `material_id` = '16671' WHERE `material_id` =49;
UPDATE `%prefix%reactor_info` SET `material_id` = '16672' WHERE `material_id` =50;




UPDATE `%prefix%reaction_static` SET `material_id` = '16634' WHERE `material_id` =1;
UPDATE `%prefix%reaction_static` SET `material_id` = '16643' WHERE `material_id` =2;
UPDATE `%prefix%reaction_static` SET `material_id` = '16647' WHERE `material_id` =3;
UPDATE `%prefix%reaction_static` SET `material_id` = '16641' WHERE `material_id` =4;
UPDATE `%prefix%reaction_static` SET `material_id` = '16640' WHERE `material_id` =5;
UPDATE `%prefix%reaction_static` SET `material_id` = '16650' WHERE `material_id` =6;
UPDATE `%prefix%reaction_static` SET `material_id` = '16635' WHERE `material_id` =7;
UPDATE `%prefix%reaction_static` SET `material_id` = '16648' WHERE `material_id` =8;
UPDATE `%prefix%reaction_static` SET `material_id` = '16633' WHERE `material_id` =9;
UPDATE `%prefix%reaction_static` SET `material_id` = '16646' WHERE `material_id` =10;
UPDATE `%prefix%reaction_static` SET `material_id` = '16651' WHERE `material_id` =11;
UPDATE `%prefix%reaction_static` SET `material_id` = '16644' WHERE `material_id` =12;
UPDATE `%prefix%reaction_static` SET `material_id` = '16652' WHERE `material_id` =13;
UPDATE `%prefix%reaction_static` SET `material_id` = '16639' WHERE `material_id` =14;
UPDATE `%prefix%reaction_static` SET `material_id` = '16636' WHERE `material_id` =15;
UPDATE `%prefix%reaction_static` SET `material_id` = '16649' WHERE `material_id` =16;
UPDATE `%prefix%reaction_static` SET `material_id` = '16653' WHERE `material_id` =17;
UPDATE `%prefix%reaction_static` SET `material_id` = '16638' WHERE `material_id` =18;
UPDATE `%prefix%reaction_static` SET `material_id` = '16637' WHERE `material_id` =19;
UPDATE `%prefix%reaction_static` SET `material_id` = '16642' WHERE `material_id` =20;
UPDATE `%prefix%reaction_static` SET `material_id` = '16663' WHERE `material_id` =21;
UPDATE `%prefix%reaction_static` SET `material_id` = '16659' WHERE `material_id` =22;
UPDATE `%prefix%reaction_static` SET `material_id` = '16660' WHERE `material_id` =23;
UPDATE `%prefix%reaction_static` SET `material_id` = '16655' WHERE `material_id` =24;
UPDATE `%prefix%reaction_static` SET `material_id` = '16668' WHERE `material_id` =25;
UPDATE `%prefix%reaction_static` SET `material_id` = '16656' WHERE `material_id` =26;
UPDATE `%prefix%reaction_static` SET `material_id` = '16669' WHERE `material_id` =27;
UPDATE `%prefix%reaction_static` SET `material_id` = '17769' WHERE `material_id` =28;
UPDATE `%prefix%reaction_static` SET `material_id` = '16665' WHERE `material_id` =29;
UPDATE `%prefix%reaction_static` SET `material_id` = '16666' WHERE `material_id` =30;
UPDATE `%prefix%reaction_static` SET `material_id` = '16667' WHERE `material_id` =31;
UPDATE `%prefix%reaction_static` SET `material_id` = '16662' WHERE `material_id` =32;
UPDATE `%prefix%reaction_static` SET `material_id` = '17960' WHERE `material_id` =33;
UPDATE `%prefix%reaction_static` SET `material_id` = '16657' WHERE `material_id` =34;
UPDATE `%prefix%reaction_static` SET `material_id` = '16658' WHERE `material_id` =35;
UPDATE `%prefix%reaction_static` SET `material_id` = '16664' WHERE `material_id` =36;
UPDATE `%prefix%reaction_static` SET `material_id` = '16661' WHERE `material_id` =37;
UPDATE `%prefix%reaction_static` SET `material_id` = '16654' WHERE `material_id` =38;
UPDATE `%prefix%reaction_static` SET `material_id` = '17959' WHERE `material_id` =39;
UPDATE `%prefix%reaction_static` SET `material_id` = '16670' WHERE `material_id` =40;
UPDATE `%prefix%reaction_static` SET `material_id` = '17317' WHERE `material_id` =41;
UPDATE `%prefix%reaction_static` SET `material_id` = '16673' WHERE `material_id` =42;
UPDATE `%prefix%reaction_static` SET `material_id` = '16683' WHERE `material_id` =43;
UPDATE `%prefix%reaction_static` SET `material_id` = '16679' WHERE `material_id` =44;
UPDATE `%prefix%reaction_static` SET `material_id` = '16682' WHERE `material_id` =45;
UPDATE `%prefix%reaction_static` SET `material_id` = '16681' WHERE `material_id` =46;
UPDATE `%prefix%reaction_static` SET `material_id` = '16680' WHERE `material_id` =47;
UPDATE `%prefix%reaction_static` SET `material_id` = '16678' WHERE `material_id` =48;
UPDATE `%prefix%reaction_static` SET `material_id` = '16671' WHERE `material_id` =49;
UPDATE `%prefix%reaction_static` SET `material_id` = '16672' WHERE `material_id` =50;




UPDATE `%prefix%reaction_static` SET `material1_id` = '16634' WHERE `material1_id` =1;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16643' WHERE `material1_id` =2;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16647' WHERE `material1_id` =3;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16641' WHERE `material1_id` =4;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16640' WHERE `material1_id` =5;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16650' WHERE `material1_id` =6;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16635' WHERE `material1_id` =7;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16648' WHERE `material1_id` =8;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16633' WHERE `material1_id` =9;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16646' WHERE `material1_id` =10;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16651' WHERE `material1_id` =11;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16644' WHERE `material1_id` =12;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16652' WHERE `material1_id` =13;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16639' WHERE `material1_id` =14;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16636' WHERE `material1_id` =15;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16649' WHERE `material1_id` =16;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16653' WHERE `material1_id` =17;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16638' WHERE `material1_id` =18;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16637' WHERE `material1_id` =19;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16642' WHERE `material1_id` =20;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16663' WHERE `material1_id` =21;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16659' WHERE `material1_id` =22;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16660' WHERE `material1_id` =23;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16655' WHERE `material1_id` =24;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16668' WHERE `material1_id` =25;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16656' WHERE `material1_id` =26;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16669' WHERE `material1_id` =27;
UPDATE `%prefix%reaction_static` SET `material1_id` = '17769' WHERE `material1_id` =28;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16665' WHERE `material1_id` =29;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16666' WHERE `material1_id` =30;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16667' WHERE `material1_id` =31;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16662' WHERE `material1_id` =32;
UPDATE `%prefix%reaction_static` SET `material1_id` = '17960' WHERE `material1_id` =33;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16657' WHERE `material1_id` =34;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16658' WHERE `material1_id` =35;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16664' WHERE `material1_id` =36;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16661' WHERE `material1_id` =37;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16654' WHERE `material1_id` =38;
UPDATE `%prefix%reaction_static` SET `material1_id` = '17959' WHERE `material1_id` =39;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16670' WHERE `material1_id` =40;
UPDATE `%prefix%reaction_static` SET `material1_id` = '17317' WHERE `material1_id` =41;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16673' WHERE `material1_id` =42;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16683' WHERE `material1_id` =43;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16679' WHERE `material1_id` =44;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16682' WHERE `material1_id` =45;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16681' WHERE `material1_id` =46;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16680' WHERE `material1_id` =47;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16678' WHERE `material1_id` =48;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16671' WHERE `material1_id` =49;
UPDATE `%prefix%reaction_static` SET `material1_id` = '16672' WHERE `material1_id` =50;




UPDATE `%prefix%reaction_static` SET `material2_id` = '16634' WHERE `material2_id` =1;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16643' WHERE `material2_id` =2;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16647' WHERE `material2_id` =3;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16641' WHERE `material2_id` =4;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16640' WHERE `material2_id` =5;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16650' WHERE `material2_id` =6;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16635' WHERE `material2_id` =7;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16648' WHERE `material2_id` =8;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16633' WHERE `material2_id` =9;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16646' WHERE `material2_id` =10;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16651' WHERE `material2_id` =11;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16644' WHERE `material2_id` =12;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16652' WHERE `material2_id` =13;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16639' WHERE `material2_id` =14;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16636' WHERE `material2_id` =15;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16649' WHERE `material2_id` =16;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16653' WHERE `material2_id` =17;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16638' WHERE `material2_id` =18;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16637' WHERE `material2_id` =19;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16642' WHERE `material2_id` =20;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16663' WHERE `material2_id` =21;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16659' WHERE `material2_id` =22;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16660' WHERE `material2_id` =23;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16655' WHERE `material2_id` =24;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16668' WHERE `material2_id` =25;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16656' WHERE `material2_id` =26;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16669' WHERE `material2_id` =27;
UPDATE `%prefix%reaction_static` SET `material2_id` = '17769' WHERE `material2_id` =28;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16665' WHERE `material2_id` =29;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16666' WHERE `material2_id` =30;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16667' WHERE `material2_id` =31;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16662' WHERE `material2_id` =32;
UPDATE `%prefix%reaction_static` SET `material2_id` = '17960' WHERE `material2_id` =33;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16657' WHERE `material2_id` =34;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16658' WHERE `material2_id` =35;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16664' WHERE `material2_id` =36;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16661' WHERE `material2_id` =37;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16654' WHERE `material2_id` =38;
UPDATE `%prefix%reaction_static` SET `material2_id` = '17959' WHERE `material2_id` =39;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16670' WHERE `material2_id` =40;
UPDATE `%prefix%reaction_static` SET `material2_id` = '17317' WHERE `material2_id` =41;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16673' WHERE `material2_id` =42;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16683' WHERE `material2_id` =43;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16679' WHERE `material2_id` =44;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16682' WHERE `material2_id` =45;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16681' WHERE `material2_id` =46;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16680' WHERE `material2_id` =47;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16678' WHERE `material2_id` =48;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16671' WHERE `material2_id` =49;
UPDATE `%prefix%reaction_static` SET `material2_id` = '16672' WHERE `material2_id` =50;




UPDATE `%prefix%reaction_static` SET `material3_id` = '16634' WHERE `material3_id` =1;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16643' WHERE `material3_id` =2;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16647' WHERE `material3_id` =3;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16641' WHERE `material3_id` =4;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16640' WHERE `material3_id` =5;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16650' WHERE `material3_id` =6;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16635' WHERE `material3_id` =7;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16648' WHERE `material3_id` =8;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16633' WHERE `material3_id` =9;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16646' WHERE `material3_id` =10;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16651' WHERE `material3_id` =11;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16644' WHERE `material3_id` =12;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16652' WHERE `material3_id` =13;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16639' WHERE `material3_id` =14;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16636' WHERE `material3_id` =15;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16649' WHERE `material3_id` =16;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16653' WHERE `material3_id` =17;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16638' WHERE `material3_id` =18;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16637' WHERE `material3_id` =19;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16642' WHERE `material3_id` =20;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16663' WHERE `material3_id` =21;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16659' WHERE `material3_id` =22;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16660' WHERE `material3_id` =23;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16655' WHERE `material3_id` =24;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16668' WHERE `material3_id` =25;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16656' WHERE `material3_id` =26;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16669' WHERE `material3_id` =27;
UPDATE `%prefix%reaction_static` SET `material3_id` = '17769' WHERE `material3_id` =28;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16665' WHERE `material3_id` =29;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16666' WHERE `material3_id` =30;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16667' WHERE `material3_id` =31;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16662' WHERE `material3_id` =32;
UPDATE `%prefix%reaction_static` SET `material3_id` = '17960' WHERE `material3_id` =33;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16657' WHERE `material3_id` =34;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16658' WHERE `material3_id` =35;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16664' WHERE `material3_id` =36;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16661' WHERE `material3_id` =37;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16654' WHERE `material3_id` =38;
UPDATE `%prefix%reaction_static` SET `material3_id` = '17959' WHERE `material3_id` =39;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16670' WHERE `material3_id` =40;
UPDATE `%prefix%reaction_static` SET `material3_id` = '17317' WHERE `material3_id` =41;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16673' WHERE `material3_id` =42;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16683' WHERE `material3_id` =43;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16679' WHERE `material3_id` =44;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16682' WHERE `material3_id` =45;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16681' WHERE `material3_id` =46;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16680' WHERE `material3_id` =47;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16678' WHERE `material3_id` =48;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16671' WHERE `material3_id` =49;
UPDATE `%prefix%reaction_static` SET `material3_id` = '16672' WHERE `material3_id` =50;




UPDATE `%prefix%reaction_static` SET `material4_id` = '16634' WHERE `material4_id` =1;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16643' WHERE `material4_id` =2;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16647' WHERE `material4_id` =3;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16641' WHERE `material4_id` =4;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16640' WHERE `material4_id` =5;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16650' WHERE `material4_id` =6;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16635' WHERE `material4_id` =7;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16648' WHERE `material4_id` =8;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16633' WHERE `material4_id` =9;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16646' WHERE `material4_id` =10;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16651' WHERE `material4_id` =11;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16644' WHERE `material4_id` =12;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16652' WHERE `material4_id` =13;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16639' WHERE `material4_id` =14;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16636' WHERE `material4_id` =15;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16649' WHERE `material4_id` =16;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16653' WHERE `material4_id` =17;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16638' WHERE `material4_id` =18;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16637' WHERE `material4_id` =19;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16642' WHERE `material4_id` =20;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16663' WHERE `material4_id` =21;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16659' WHERE `material4_id` =22;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16660' WHERE `material4_id` =23;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16655' WHERE `material4_id` =24;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16668' WHERE `material4_id` =25;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16656' WHERE `material4_id` =26;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16669' WHERE `material4_id` =27;
UPDATE `%prefix%reaction_static` SET `material4_id` = '17769' WHERE `material4_id` =28;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16665' WHERE `material4_id` =29;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16666' WHERE `material4_id` =30;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16667' WHERE `material4_id` =31;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16662' WHERE `material4_id` =32;
UPDATE `%prefix%reaction_static` SET `material4_id` = '17960' WHERE `material4_id` =33;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16657' WHERE `material4_id` =34;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16658' WHERE `material4_id` =35;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16664' WHERE `material4_id` =36;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16661' WHERE `material4_id` =37;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16654' WHERE `material4_id` =38;
UPDATE `%prefix%reaction_static` SET `material4_id` = '17959' WHERE `material4_id` =39;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16670' WHERE `material4_id` =40;
UPDATE `%prefix%reaction_static` SET `material4_id` = '17317' WHERE `material4_id` =41;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16673' WHERE `material4_id` =42;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16683' WHERE `material4_id` =43;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16679' WHERE `material4_id` =44;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16682' WHERE `material4_id` =45;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16681' WHERE `material4_id` =46;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16680' WHERE `material4_id` =47;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16678' WHERE `material4_id` =48;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16671' WHERE `material4_id` =49;
UPDATE `%prefix%reaction_static` SET `material4_id` = '16672' WHERE `material4_id` =50;