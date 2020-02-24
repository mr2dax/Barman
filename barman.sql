-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2015 at 10:47 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barman`
--

-- --------------------------------------------------------

--
-- Table structure for table `Beverages`
--

CREATE TABLE IF NOT EXISTS `Beverages` (
  `ID` int(5) NOT NULL auto_increment COMMENT 'unique ID',
  `Name` varchar(30) NOT NULL COMMENT 'name of the product',
  `Type_ID` int(3) NOT NULL COMMENT 'id of the type of the beverage',
  `Alc` tinyint(1) NOT NULL COMMENT 'Beverage alcoholic or not',
  `Vol` float(5,3) NOT NULL COMMENT 'volume of the product',
  `Price` int(7) default NULL COMMENT 'price of the product',
  `Supplier_ID` varchar(15) default NULL COMMENT 'ID of the source of the beverage',
  `Avail` tinyint(1) NOT NULL default '1' COMMENT 'Availability',
  `Stock` smallint(5) unsigned NOT NULL COMMENT 'amount of beverage unit',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding the beverages at a bar' AUTO_INCREMENT=132 ;

--
-- Dumping data for table `Beverages`
--

INSERT INTO `Beverages` (`ID`, `Name`, `Type_ID`, `Alc`, `Vol`, `Price`, `Supplier_ID`, `Avail`, `Stock`) VALUES
(1, 'Smirnoff No 21 Red Vodka', 1, 1, 1.000, 5990, '1', 1, 0),
(2, 'Absolut Blue 40% Vodka', 1, 1, 0.700, 4900, '1', 1, 0),
(3, 'Russky Standard Original Vodka', 1, 1, 0.700, 5150, '1', 1, 0),
(4, 'Grey Goose Vodka', 1, 1, 0.700, 12500, '1', 1, 0),
(5, 'Ciroc Vodka', 1, 1, 0.700, 15205, '1', 1, 0),
(6, 'Bombay Sapphire Gin', 2, 1, 0.700, 7245, '1', 1, 0),
(7, 'Hendrick''s Gin', 2, 1, 0.700, 10140, '1', 1, 0),
(8, 'Tanqueray', 2, 1, 0.700, 7990, '1', 1, 0),
(9, 'Beefeater', 2, 1, 0.700, 4770, '1', 1, 0),
(10, 'GVine', 2, 1, 0.700, 13360, '1', 1, 0),
(11, 'Bacardi Superior', 3, 1, 1.000, 5990, '1', 1, 0),
(12, 'Bacardi Gold', 3, 1, 0.700, 5250, '1', 1, 0),
(13, 'Bacardi Black', 3, 1, 0.700, 5710, '1', 1, 0),
(14, 'Havana Club 7 anos', 3, 1, 0.700, 10600, '1', 1, 0),
(15, 'Ron Zacapa 23', 3, 1, 0.700, 17955, '1', 1, 0),
(16, 'Diplomatico Reserva Exclusiva', 3, 1, 0.700, 13880, '1', 1, 0),
(17, 'Stroh 80', 3, 1, 0.500, 6570, '1', 1, 0),
(18, 'Pitu Cachaca', 3, 1, 0.700, 5650, '1', 1, 0),
(19, 'Jack Daniels', 4, 1, 1.500, 12655, '1', 1, 0),
(20, 'Jameson', 4, 1, 1.000, 7690, '1', 1, 0),
(21, 'Chivas Regal 12', 4, 1, 0.700, 8360, '1', 1, 0),
(22, 'Woodford Reserve', 4, 1, 0.700, 11500, '1', 1, 0),
(23, 'Nikka From the Barrel', 4, 1, 0.500, 12305, '1', 1, 0),
(24, 'Ardbeg', 4, 1, 0.700, 16435, '1', 1, 0),
(25, 'Scapa Malt 16', 4, 1, 0.700, 17125, '1', 1, 0),
(26, 'Jose Cuervo Silver', 5, 1, 1.000, 6885, '1', 1, 0),
(27, 'El Jimador Reposado', 5, 1, 0.700, 5675, '1', 1, 0),
(28, 'Patron Silver', 5, 1, 0.700, 16840, '1', 1, 0),
(29, 'Patron XO Cafe', 5, 1, 0.700, 9610, '1', 1, 0),
(30, 'Hennessy Fine', 6, 1, 0.700, 14500, '1', 1, 0),
(31, 'Courvoisier VS', 6, 1, 0.700, 9770, '1', 1, 0),
(32, 'Martell VSOP', 6, 1, 0.700, 13990, '1', 1, 0),
(33, 'Martini Bianco', 7, 1, 0.750, 2090, '1', 1, 0),
(34, 'Martini Rosso', 7, 1, 0.750, 2090, '1', 1, 0),
(35, 'Martini Extra Dry', 7, 1, 0.750, 2090, '1', 1, 0),
(36, 'Campari', 8, 1, 0.700, 4695, '1', 1, 0),
(37, 'Aperol', 8, 1, 1.000, 4795, '1', 1, 0),
(38, 'Jagermeister', 8, 1, 1.000, 4895, '1', 1, 0),
(39, 'Unicum', 8, 1, 0.700, 4400, '1', 1, 0),
(40, 'Kahlua', 8, 1, 0.700, 5410, '1', 1, 0),
(41, 'Bols Creme de Cassis', 8, 1, 0.700, 3645, '1', 1, 0),
(42, 'Heering', 8, 1, 0.700, 6985, '1', 1, 0),
(43, 'Grand Marnier', 8, 1, 0.700, 8500, '1', 1, 0),
(44, 'St. Germain', 8, 1, 0.700, 12865, '1', 1, 0),
(45, 'Disarono Amaretto', 8, 1, 0.700, 6900, '1', 1, 0),
(46, 'Galliano Vanilla', 8, 1, 0.700, 9375, '1', 1, 0),
(47, 'Wenneker Blue Curacao', 8, 1, 0.700, 3855, '1', 1, 0),
(48, 'Cointreau', 8, 1, 0.700, 7615, '1', 1, 0),
(49, 'Baileys', 8, 1, 0.700, 4550, '1', 1, 0),
(50, 'Bols Banana', 8, 1, 0.700, 3645, '1', 1, 0),
(51, 'Kwai Feh Lychee', 8, 1, 0.700, 5255, '1', 1, 0),
(52, 'Absinthe Tunel Blue', 8, 1, 0.700, 8020, '1', 1, 0),
(53, 'Chambord', 8, 1, 0.500, 6710, '1', 1, 0),
(54, 'Bols Triple Sec', 8, 1, 0.700, 4395, '1', 1, 0),
(55, 'Midori', 8, 1, 0.700, 6200, '1', 1, 0),
(56, 'Kosher Pear Palinka', 9, 1, 0.700, 9950, '5', 1, 0),
(57, 'Kosher Plum Palinka', 9, 1, 0.700, 9950, '5', 1, 0),
(58, 'Kosher Apricot Palinka', 9, 1, 0.700, 9950, '5', 1, 0),
(59, 'Coca Cola', 10, 0, 0.250, 152, '1', 1, 0),
(60, 'Coca Cola Light', 10, 0, 0.250, 153, '1', 1, 0),
(61, 'Kinley Tonic Water', 10, 0, 0.250, 155, '1', 1, 0),
(62, 'Kinley Ginger Ale', 10, 0, 0.250, 156, '1', 1, 0),
(63, 'Sprite', 10, 0, 0.250, 157, '1', 1, 0),
(64, 'Happy Day Apple', 11, 0, 1.000, 415, '1', 1, 0),
(65, 'Happy Day Orange', 11, 0, 1.000, 415, '1', 1, 0),
(66, 'Happy Day Pineapple', 11, 0, 1.000, 415, '1', 1, 0),
(67, 'Ruby Red Cranberry', 11, 0, 1.000, 525, '1', 1, 0),
(68, 'Happy Day Tomato', 11, 0, 1.000, 415, '1', 1, 0),
(69, 'Happy Day Pear', 11, 0, 1.000, 415, '1', 1, 0),
(70, 'Happy Day Strawberry', 11, 0, 1.000, 495, '1', 1, 0),
(71, 'Happy Day Grapefruit', 11, 0, 1.000, 415, '1', 1, 0),
(72, 'Cappy Orange', 11, 0, 0.200, 155, '1', 1, 0),
(73, 'Cappy Apple', 11, 0, 0.200, 155, '1', 1, 0),
(74, 'Cappy Peach', 11, 0, 0.200, 155, '1', 1, 0),
(75, 'Cappy Strawberry', 11, 0, 0.200, 155, '1', 1, 0),
(76, 'Fabbri Passionfruit', 12, 0, 1.000, 4490, '1', 1, 0),
(77, 'Fabbri Papaya', 12, 0, 1.000, 4490, '1', 1, 0),
(78, 'Fabbri Coconut', 12, 0, 1.000, 4390, '1', 1, 0),
(79, 'Fabbri Orgeat', 12, 0, 1.000, 4390, '1', 1, 0),
(80, 'Fabbri Mango', 12, 0, 1.000, 4390, '1', 1, 0),
(81, 'Fabbri Vanilla', 12, 0, 1.000, 4390, '1', 1, 0),
(82, 'Fabbri Grenadine', 12, 0, 1.000, 4390, '1', 1, 0),
(83, 'Fabbri Amarena Cherry', 12, 0, 1.000, 4390, '1', 1, 0),
(84, 'Fabbri Raspberry', 12, 0, 1.000, 4390, '1', 1, 0),
(85, 'Fabbri Elderflower', 12, 0, 1.000, 4490, '1', 1, 0),
(86, 'Fabbri Cinnamon', 12, 0, 1.000, 4390, '1', 1, 0),
(87, 'Hungária Extra Dry', 15, 1, 0.200, 525, '1', 1, 0),
(88, 'Hungária Irsai Olivér Doux', 15, 1, 0.750, 1915, '1', 1, 0),
(89, 'Hungária Grande Cuvée Brut', 15, 1, 0.750, 1915, '1', 1, 0),
(90, 'Moët & Chandon Brut Imperial', 15, 1, 0.750, 13125, '1', 1, 0),
(91, 'Angostura', 17, 1, 0.200, 4100, '1', 1, 0),
(92, 'Jerry Thomas', 17, 1, 0.200, 3375, '1', 1, 0),
(93, 'Grapefruit', 17, 1, 0.200, 3375, '1', 1, 0),
(94, 'Rose Water', 17, 1, 0.200, 3375, '1', 1, 0),
(95, 'Espresso', 16, 0, 0.030, 30, '3', 1, 0),
(96, 'Rajos Szikviz', 10, 0, 1.350, 80, '8', 1, 0),
(97, 'Sugar Syrup', 12, 0, 1.000, 0, '3', 1, 0),
(98, 'Primator Exclusive', 14, 1, 0.500, 500, '2', 1, 0),
(99, 'Primator India Pale Ale', 14, 1, 0.500, 500, '2', 1, 0),
(100, 'Primator Weizenbier', 14, 1, 0.500, 500, '2', 1, 0),
(101, 'Primator Premium Dark', 14, 1, 0.500, 500, '2', 1, 0),
(102, 'Lemon Juice', 11, 0, 1.000, 1000, '3', 1, 0),
(103, 'Lime Juice', 11, 0, 1.000, 5000, '3', 1, 0),
(104, 'Villanyi Chardonnay', 13, 1, 0.750, 0, '1', 1, 0),
(105, 'Villanyi Roze', 13, 1, 0.750, 0, '1', 1, 0),
(106, 'Tokaji Aszu', 13, 1, 0.550, 0, '1', 1, 0),
(107, 'Egri Bulls Blood', 13, 1, 0.750, 0, '1', 1, 0),
(108, 'Egri Pi Wine', 13, 1, 0.750, 0, '1', 1, 0),
(109, 'Villanyi Cabernet Franc', 13, 1, 0.750, 0, '1', 1, 0),
(110, 'Szekszardi Pinot Noir', 13, 1, 0.750, 0, '1', 1, 0),
(111, 'Egri Cabernet Cuvee', 13, 1, 0.750, 0, '1', 1, 0),
(112, 'Strawberry puree', 18, 0, 1.000, 0, '3', 1, 0),
(113, 'Honey', 12, 0, 1.000, 0, '3', 1, 0),
(114, 'Red Currant puree', 18, 0, 1.000, 0, '3', 1, 0),
(115, 'Double Cream', 12, 0, 1.000, 0, '3', 1, 0),
(116, 'Red Bull', 10, 0, 0.250, 395, '1', 1, 0),
(117, 'Red Bull Sugarfree', 10, 0, 0.250, 395, '1', 1, 0),
(118, 'Villa Sandi Frizzante', 15, 1, 0.750, 1900, '1', 0, 0),
(119, 'Svituris Extra', 14, 1, 0.330, 450, '9', 1, 0),
(120, 'Luxardo Maraschino', 8, 1, 0.700, 4880, '1', 1, 0),
(121, 'Luxardo Sambuca', 8, 1, 0.700, 0, '1', 1, 0),
(122, 'Fabbri Blueberry', 12, 0, 0.560, 2680, '1', 1, 0),
(123, 'Fabbri Mint', 12, 0, 1.000, 4390, '1', 1, 0),
(124, 'Fabbri Melon', 12, 0, 1.000, 4390, '1', 1, 0),
(125, 'Malibu', 3, 1, 1.000, 5850, '1', 1, 0),
(126, 'Raspberry Puree', 18, 0, 1.000, 0, '3', 1, 0),
(127, 'Fabbri Strawberry', 12, 0, 1.000, 4390, '1', 1, 0),
(128, 'Lychee Juice', 11, 0, 1.000, 0, '1', 1, 0),
(131, 'Beefeater', 2, 1, 1.000, 6285, '1', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Bev_Type`
--

CREATE TABLE IF NOT EXISTS `Bev_Type` (
  `ID` int(3) NOT NULL auto_increment COMMENT 'unique ID',
  `Type` varchar(15) NOT NULL COMMENT 'types of the beverages',
  PRIMARY KEY  (`ID`),
  KEY `Type` (`Type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding beverage types' AUTO_INCREMENT=19 ;

--
-- Dumping data for table `Bev_Type`
--

INSERT INTO `Bev_Type` (`ID`, `Type`) VALUES
(1, 'Vodka'),
(2, 'Gin'),
(3, 'Rum'),
(4, 'Whiskey'),
(5, 'Tequila'),
(6, 'Cognac'),
(7, 'Vermouth'),
(8, 'Liqueur'),
(9, 'Palinka'),
(10, 'Soft'),
(11, 'Juice'),
(12, 'Syrup'),
(13, 'Wine'),
(14, 'Beer'),
(15, 'Champagne'),
(16, 'Coffee'),
(17, 'Bitter'),
(18, 'Puree');

-- --------------------------------------------------------

--
-- Table structure for table `Cocktails`
--

CREATE TABLE IF NOT EXISTS `Cocktails` (
  `ID` int(7) NOT NULL auto_increment COMMENT 'unique ID',
  `Name` varchar(30) NOT NULL COMMENT 'name of the cocktail',
  `Ingredients` varchar(150) NOT NULL COMMENT 'the ingredients that make up the cocktail',
  `Alc` tinyint(1) NOT NULL COMMENT 'contains alcohol or not',
  `Sig` tinyint(1) NOT NULL COMMENT 'signature cocktail or not',
  `Shot` tinyint(1) NOT NULL COMMENT 'shot or not',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding cocktails' AUTO_INCREMENT=91 ;

--
-- Dumping data for table `Cocktails`
--

INSERT INTO `Cocktails` (`ID`, `Name`, `Ingredients`, `Alc`, `Sig`, `Shot`) VALUES
(1, 'Bird Fizz', 'b-6-50,g-3-1,b-103-25,g-2-1,b-80-20', 1, 1, 0),
(2, 'Dark Apple', 'b-6-50,f-6-0.25,b-64-60,b-102-20,g-2-1,b-97-20,g-3-1,b-41-40,b-96-20', 1, 1, 0),
(3, 'Blue Bird', 'b-11-50,f-2-0.125,g-2-1,b-78-15,b-103-25,b-97-5,b-47-15', 1, 1, 0),
(4, 'Devil in Disguise', 'b-1-45,f-5-3,b-111-30,g-3-1,b-67-60,g-2-1,g-1-1,b-62-20', 1, 1, 0),
(5, 'Sing!', 'b-19-45,f-7-0.125,g-7-1,b-46-10,f-2-0.5,g-1-1,b-79-10,g-2-1,b-103-20,g-3-1,b-62-20', 1, 1, 0),
(6, 'Palinka Sour', 'b-56-45,f-1-0.125,g-2-1,b-97-15,g-3-1,b-102-30,b-91-3,b-91-1', 1, 1, 0),
(7, 'Basil Livre!', 'b-18-60,f-2-0.5,b-116-100,g-3-1,g-2-1,g-27-1', 1, 1, 0),
(8, 'O.G.D.', 'b-11-30,f-3-0.125,g-2-1,b-48-15,g-3-1,b-102-10,b-97-10,b-65-40', 1, 1, 0),
(9, 'Hummingbird', 'b-1-45,f-2-0.125,g-28-1,b-48-15,f-4-1,g-1-1,b-103-20,g-2-1,b-70-60,g-3-1,b-59-150', 1, 1, 0),
(10, 'Mexican''t', 'b-26-45,b-48-15,b-103-45,g-3-1,b-113-15,g-2-1', 1, 1, 0),
(11, 'Coffee of the Night', 'b-13-50,b-95-30,b-113-10,b-42-20', 1, 1, 0),
(12, 'Negroni', 'b-6-30,g-2-1,b-36-30,b-34-30', 1, 0, 0),
(13, 'Old Fashioned', 'b-22-60,f-10-5,g-2-1,b-91-3,b-94-3,b-93-3,b-81-10,b-120-10', 1, 0, 0),
(14, 'Sidecar', 'b-31-45,g-2-1,b-48-20,b-102-20', 1, 0, 0),
(15, 'Daiquiri', 'b-11-60,f-2-0.125,g-2-1,b-103-20,b-97-20', 1, 0, 0),
(16, 'Strawberry Daiquiri', 'b-11-60,g-2-1,b-103-20,b-112-20,b-97-10', 1, 0, 0),
(17, 'Appletini', 'b-1-45,f-6-0.25,g-2-1,b-64-40,b-97-15,b-103-10', 1, 0, 0),
(18, 'Gin Martini', 'b-6-50,g-1-1,b-35-10,g-2-1', 1, 0, 0),
(19, 'Vodka Martini', 'b-1-45,b-35-15', 1, 0, 0),
(20, 'French Martini', 'b-1-45,f-5-2,g-1-1,b-53-20,g-2-1,b-66-30,b-97-5', 1, 0, 0),
(21, 'Pina Colada', 'b-11-45,g-1-1,b-125-15,g-2-1,b-78-30,g-3-1,b-115-15,b-66-60', 1, 0, 0),
(22, 'Passion Martini', 'b-1-45,g-2-1,b-76-30,b-103-15', 1, 0, 0),
(23, 'Raspberry Martini', 'b-1-45,f-5-3,g-2-1,b-84-15,g-1-1,b-102-15,b-53-15', 1, 0, 0),
(24, 'Margarita', 'b-26-45,g-2-1,b-48-15,g-3-1,b-103-30', 1, 0, 0),
(25, 'Strawberry Margarita', 'b-26-45,f-4-1,g-3-1,b-48-15,g-2-1,b-112-20,b-127-20,b-102-30', 1, 0, 0),
(26, 'Bellini', 'b-87-100,b-74-40,g-2-1', 1, 0, 0),
(27, 'Aperol Spritz', 'b-37-60,f-3-0.25,g-3-1,b-87-100,g-2-1,b-96-30,b-65-20', 1, 0, 0),
(28, 'Mojito', 'b-11-60,f-7-0.125,g-3-1,b-97-30,f-2-0.5,g-2-1,b-102-10,g-7-1', 1, 0, 0),
(29, 'Long Island Iced Tea', 'b-1-15,f-1-0.125,g-2-1,b-6-15,g-3-1,b-11-15,b-26-15,b-54-15,b-102-20,b-59-150', 1, 0, 0),
(30, 'Cosmopolitan', 'b-1-45,g-2-1,b-48-15,b-103-15,b-97-5,b-67-30', 1, 0, 0),
(31, 'Black Russian', 'b-1-60,b-40-30,g-2-1,g-3-1', 1, 0, 0),
(32, 'White Russian', 'b-1-60,b-40-30,b-115-30,g-2-1,g-3-1', 1, 0, 0),
(33, 'Manhattan', 'b-22-60,g-3-1,b-34-10,g-2-1,b-33-10,b-91-3', 1, 0, 0),
(34, 'Strawberry Mojito', 'b-11-60,f-7-0.125,g-2-1,b-102-10,f-2-0.5,g-3-1,b-97-10,f-4-1,b-112-30,b-96-200,g-7-1', 1, 0, 0),
(35, 'Passionfruit Mojito', 'b-11-60,f-2-0.5,g-2-1,b-97-5,f-7-0.125,g-3-1,b-76-40,g-7-1,b-96-200,b-102-10', 1, 0, 0),
(36, 'Mango Mojito', 'b-11-60,f-2-0.5,g-2-1,b-102-10,f-7-0.125,g-3-1,b-80-40,g-7-1,b-96-200', 1, 0, 0),
(37, 'Papaya Mojito', 'b-11-60,f-2-0.5,g-2-1,b-102-10,f-7-0.125,g-3-1,b-77-40,g-7-1,b-96-200', 1, 0, 0),
(38, 'Mai Tai', 'b-11-20,f-2-0.125,b-12-20,g-1-1,b-45-20,g-2-1,b-79-10,g-1-1,b-48-10,b-97-5,b-103-10,b-65-20,b-66-20,b-13-15', 1, 0, 0),
(39, 'Kir Royal', 'b-87-120,f-5-1,g-1-1,b-41-10,g-2-1', 1, 0, 0),
(40, 'Mimosa', 'b-87-75,g-2-1,b-65-75', 1, 0, 0),
(41, 'Blue Kamikaze', 'b-1-30,g-2-1,b-47-30,b-102-10', 1, 0, 0),
(42, 'Blue Kamikaze Long', 'b-1-60,g-3-1,b-47-30,g-2-1,b-102-10,b-96-100', 1, 0, 0),
(43, 'Bloody Mary', 'b-1-60,f-1-0.125,g-1-1,b-102-20,g-2-1,b-68-100,g-41-3,g-40-3', 1, 0, 0),
(44, 'Bloody Maria', 'b-26-60,f-2-0.125,g-2-1,b-102-20,g-3-1,b-68-100,g-39-1,g-29-1', 1, 0, 0),
(45, 'Caipirinha', 'b-18-60,f-10-15,f-2-1,g-3-1,g-2-1', 1, 0, 0),
(46, 'Caipiroska', 'b-1-60,f-10-15,f-2-1,g-2-1,g-3-1', 1, 0, 0),
(47, 'Espresso Martini', 'b-95-30,b-1-45,g-2-1,b-97-5,g-31-3,b-40-15,b-81-5,b-115-5', 1, 0, 0),
(48, 'Cuba Libre', 'b-11-60,f-1-0.25,g-3-1,b-59-200,g-2-1,b-103-10', 1, 0, 0),
(49, 'Bullfrog', 'b-1-15,f-1-0.125,g-3-1,b-11-15,g-2-1,b-26-15,b-6-15,b-47-15,b-102-20,b-116-250', 1, 0, 0),
(50, 'Sex on the Beach', 'b-1-40,f-3-0.125,b-58-10,b-65-50,g-2-1,b-66-25,g-3-1,b-82-10,b-67-25', 1, 0, 0),
(51, 'Swimming Pool', 'b-1-20,g-2-1,b-125-20,b-11-20,g-3-1,b-78-20,b-115-10,b-66-100,b-47-20', 1, 0, 0),
(52, 'Tequila Sunrise', 'b-26-60,f-3-0.125,g-3-1,b-65-100,g-2-1,b-82-20', 1, 0, 0),
(53, 'Mint Julep', 'b-19-60,f-7-0.125,g-3-1,b-97-20,g-2-1,g-7-1', 1, 0, 0),
(54, 'Americano', 'b-96-30,g-2-1,b-36-30,g-3-1,b-34-30', 1, 0, 0),
(55, 'Whiskey Sour', 'b-19-45,g-3-1,b-97-15,g-2-1,b-102-30,b-91-3', 1, 0, 0),
(56, 'Moscow Mule', 'b-1-50,f-2-1,g-2-1,b-102-30,g-3-1,b-97-20,b-62-50,b-93-5', 1, 0, 0),
(57, 'Midori Sour', 'b-55-45,g-2-1,b-102-30,g-3-1,b-91-3', 1, 0, 0),
(58, 'Lychee Martini', 'b-1-30,g-1-1,b-51-30,g-2-1,b-97-10,b-103-15', 1, 0, 0),
(59, 'Raspberry Mojito', 'b-11-60,f-2-0.5,g-2-1,b-102-10,f-7-0.125,g-3-1,b-97-10,b-126-20,g-7-1,b-84-20,b-96-200', 1, 0, 0),
(60, 'Screwdriver', 'b-1-60,f-3-0.125,g-3-1,b-65-100,g-2-1', 1, 0, 0),
(61, 'Harvey Wallbanger', 'b-1-40,f-3-0.125,g-3-1,b-46-20,g-2-1,b-65-100', 1, 0, 0),
(62, 'Gin Fizz', 'b-6-60,g-2-1,b-102-30,g-3-1,b-97-10,b-96-80', 1, 0, 0),
(63, 'Ultimate June Bug', 'b-55-20,g-3-1,b-125-20,g-2-1,b-50-15,g-8-1,b-103-15,g-42-1,b-66-40', 1, 0, 0),
(64, 'Lychee Gori', 'b-85-15,g-1-1,b-62-100,g-3-1,g-2-1', 0, 0, 0),
(65, 'Virgin Colada', 'b-66-120,g-2-1,b-78-30,g-3-1,b-115-15', 0, 0, 0),
(66, 'Virgin Mojito', 'b-63-250,f-7-0.125,g-2-1,b-102-10,f-2-0.5,g-3-1,b-97-30,g-7-1', 0, 0, 0),
(67, 'Virgin Mary', 'b-68-160,f-3-,g-2-1,b-102-20,f-1-0.125,g-3-1,g-41-3,g-40-3', 0, 0, 0),
(68, 'Shirley Temple', 'b-63-250,g-1-1,b-82-10,f-2-0.125,g-3-1,g-2-1', 0, 0, 0),
(69, 'Lemon Mint', 'b-102-50,f-7-0.25,g-2-1,b-97-75,g-3-1', 0, 0, 0),
(70, 'Blue Bull', 'b-1-10,b-47-10,b-103-5,b-116-15', 1, 1, 1),
(71, 'Fly Like An Eagle', 'b-38-20,b-49-20,b-52-20', 1, 1, 1),
(72, 'Sing Like A Bird', 'b-29-20,b-49-20,b-17-20', 1, 1, 1),
(73, 'Jagertron', 'b-38-20,b-29-20', 1, 1, 1),
(74, 'Bull''s Eye', 'b-1-15,b-41-10,b-103-5,b-67-10', 1, 1, 1),
(75, 'Jagermeisterin', 'b-38-20,b-64-20', 1, 1, 1),
(76, 'Honey Moon', 'b-64-150,g-3-1,b-65-150,g-2-1,b-113-30,g-17-1,b-102-10,g-1-1', 0, 1, 0),
(77, 'Waikiki', 'b-66-150,g-8-1,b-76-30,g-2-1,b-78-30,g-3-1', 0, 1, 0),
(78, 'Berry Breeze', 'b-112-30,f-12-6,g-3-1,b-76-30,g-2-1,b-103-30,g-7-1,b-63-150,g-13-1', 0, 1, 0),
(79, 'Sweet Dreams', 'b-112-50,f-4-1,g-2-1,b-80-50,g-1-1,b-66-100,g-3-1', 0, 1, 0),
(80, 'Blue Kamikaze Shot', 'b-1-20,b-47-10,b-102-10', 1, 0, 1),
(81, 'Lemon Drop', 'b-1-30,f-1-0.125,b-102-5,b-97-5', 1, 0, 1),
(82, 'Orgasm', 'b-45-20,b-40-20,b-49-20', 1, 0, 1),
(83, 'Doo Doo', 'b-1-25,g-40-2,b-102-5,g-46-1', 1, 0, 1),
(84, 'Woo Woo', 'b-26-25,g-40-2,b-102-5,g-46-1', 1, 0, 1),
(85, 'Sex on the Beach Shot', 'b-1-20,b-58-10,b-67-10', 1, 0, 1),
(86, 'B52', 'b-40-20,b-49-20,b-48-20', 1, 0, 1),
(87, 'Jagerbomb', 'b-38-40,b-116-100', 1, 0, 1),
(88, 'Sambuca Russian Style', 'b-121-60,g-2-1,g-31-3,g-3-1', 1, 0, 1),
(89, 'Vodka Russian Style', 'b-1-100,g-2-1,g-45-1', 1, 0, 1),
(90, 'Bazeg', 'b-58-40,g-44-1,g-43-1,g-2-1,g-1-1', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Fruit_Veg`
--

CREATE TABLE IF NOT EXISTS `Fruit_Veg` (
  `ID` int(4) NOT NULL auto_increment COMMENT 'unique ID',
  `Name` varchar(30) NOT NULL COMMENT 'name of the fruit or vegetable',
  `Metric` varchar(2) NOT NULL COMMENT 'measurement metric',
  `Amount` float NOT NULL COMMENT 'amount of the metric',
  `Price` int(7) default NULL COMMENT 'price of the product',
  `Weight` int(7) default NULL COMMENT 'weight per piece OR piece per package',
  `Avail` tinyint(1) NOT NULL default '1' COMMENT 'Availability',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding the fruits and vegetables th' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `Fruit_Veg`
--

INSERT INTO `Fruit_Veg` (`ID`, `Name`, `Metric`, `Amount`, `Price`, `Weight`, `Avail`) VALUES
(1, 'Lemon', 'KG', 1, 431, 98, 1),
(2, 'Lime', 'KG', 1, 1523, 100, 1),
(3, 'Orange', 'KG', 1, 253, 131, 1),
(4, 'Strawberry', 'KG', 1, 1064, 15, 1),
(5, 'Raspberry', 'PK', 1, 1330, 20, 1),
(6, 'Apple', 'KG', 1, 333, 150, 1),
(7, 'Mint', 'PL', 1, 466, 1, 1),
(8, 'Basil', 'PL', 1, 466, 1, 1),
(9, 'Rosemary', 'PL', 1, 466, 1, 1),
(10, 'Maisu Demerara', 'KG', 0.5, 1100, 6, 1),
(11, 'Maisu Light Muscovado', 'KG', 0.5, 1900, 6, 1),
(12, 'Blackberry', 'PK', 1, 1111, 20, 1),
(13, 'Blueberry', 'PK', 1, 794, 40, 1),
(14, 'Lychee', 'PK', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Garnish`
--

CREATE TABLE IF NOT EXISTS `Garnish` (
  `ID` int(7) NOT NULL auto_increment COMMENT 'unique ID',
  `Name` varchar(30) NOT NULL COMMENT 'name of the garnish',
  `Metric` varchar(2) NOT NULL COMMENT 'measurement metric',
  `Amount` float NOT NULL COMMENT 'amount of the metric',
  `Price` int(7) default NULL COMMENT 'price of the product',
  `Quantity` int(5) default NULL COMMENT 'quantity per metric',
  `Avail` tinyint(1) NOT NULL COMMENT 'Availability',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding the misc. garnishes used at ' AUTO_INCREMENT=47 ;

--
-- Dumping data for table `Garnish`
--

INSERT INTO `Garnish` (`ID`, `Name`, `Metric`, `Amount`, `Price`, `Quantity`, `Avail`) VALUES
(1, 'Bamboo stick', 'PK', 1, 370, 50, 1),
(2, 'Bar serviette', 'PK', 1, 397, 100, 1),
(3, 'Bar straw', 'PK', 1, 805, 500, 1),
(4, 'Orange peel', 'PC', 1, 0, 1, 1),
(5, 'Lemon peel', 'PC', 1, 0, 1, 1),
(6, 'Lime peel', 'PC', 1, 0, 1, 1),
(7, 'Mint Sprig', 'PC', 1, 60, 1, 1),
(8, 'Coconut zest', 'PN', 1, 0, 1, 1),
(9, 'Lime shell', 'PC', 1, 0, 1, 1),
(10, 'Pepper seed', 'PN', 1, 0, 1, 1),
(11, 'Ground cinnamon', 'PN', 1, 0, 1, 1),
(12, 'Cinnamon stick', 'PC', 1, 0, 1, 1),
(13, 'Icing sugar', 'PN', 1, 0, 1, 1),
(14, 'Cinnamon bark', 'PC', 1, 0, 1, 1),
(15, 'Ginger slice', 'PC', 1, 0, 1, 1),
(16, 'Cucumber slice', 'PC', 1, 0, 1, 1),
(17, 'Apple fan', 'PC', 1, 0, 1, 1),
(18, 'Lime wedge', 'PC', 1, 0, 1, 1),
(19, 'Lime wheel', 'PC', 1, 0, 1, 1),
(20, 'Lime half', 'PC', 1, 0, 1, 1),
(21, 'Lemon wedge', 'PC', 1, 0, 1, 1),
(22, 'Lemon wheel', 'PC', 1, 0, 1, 1),
(23, 'Lemon half wheel', 'PC', 1, 0, 1, 1),
(24, 'Orange wheel', 'PC', 1, 0, 1, 1),
(25, 'Orange wedge', 'PC', 1, 0, 1, 1),
(26, 'Orange half wheel', 'PC', 1, 0, 1, 1),
(27, 'Basil sprig', 'PC', 1, 0, 1, 1),
(28, 'Rosemary sprig', 'PC', 1, 0, 1, 1),
(29, 'Salt', 'PN', 1, 0, 1, 1),
(30, 'Hot paprika slice', 'PC', 1, 0, 1, 1),
(31, 'Coffee bean', 'PC', 1, 0, 1, 1),
(32, 'Olive', 'PC', 1, 0, 1, 1),
(33, 'Maraschino cherry', 'PC', 1, 0, 1, 1),
(35, 'Celery', 'PC', 1, 0, 1, 1),
(36, 'Tomato wedge', 'PC', 1, 0, 1, 1),
(37, 'Baby tomato', 'PC', 1, 0, 1, 1),
(38, 'Celery salt', 'PN', 1, 0, 1, 1),
(39, 'Pepper', 'PN', 1, 0, 1, 1),
(40, 'Tabasco', 'DP', 1, 0, 1, 1),
(41, 'Worchestershire sauce', 'DP', 1, 0, 1, 1),
(42, 'Banana slice', 'PC', 1, 0, 1, 1),
(43, 'Onion slice', 'PC', 1, 0, 1, 1),
(44, 'Chili sauce', 'PN', 1, 0, 1, 1),
(45, 'Pickle', 'PC', 1, 0, 1, 1),
(46, 'Green unstuffed olive', 'PC', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Inventory`
--

CREATE TABLE IF NOT EXISTS `Inventory` (
  `ID` tinyint(9) NOT NULL auto_increment COMMENT 'unique ID',
  `Inventory` text NOT NULL COMMENT 'inventory information data',
  `Inv_Date` datetime NOT NULL COMMENT 'date and time when the inventory was due',
  `Stamp` datetime NOT NULL COMMENT 'when the inventory was submitted',
  `By_User` varchar(10) NOT NULL COMMENT 'by which user was the inventory entry done',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding inventory' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Inventory`
--

INSERT INTO `Inventory` (`ID`, `Inventory`, `Inv_Date`, `Stamp`, `By_User`) VALUES
(1, '1-1.85,2-0.9,3-0.85,4-0.65,5-1,6-1.6,7-0.75,8-0.85,9-2.3,10-0.9,11-1.55,12-1,13-0.7,14-0.85,15-0.9,16-0.95,17-1,18-0.8,19-0.35,20-1,21-0.4,22-0.45,23-1,24-1,25-1,26-1,27-0,28-1,29-1,30-0.95,31-1,32-1,33-0.85,34-0.9,35-1,36-0.9,37-0.95,38-0.5,39-0.5,40-1.6,41-1.3,42-0.95,43-1,44-0.2,45-0.95,46-0.45,47-0.65,48-0.8,49-0.9,50-1,51-1,52-1,53-1,54-1,55-1,56-2.25,57-1,58-2.6,87-23,88-0,89-1,90-1,91-0.95,92-0.95,93-0.95,94-0.95,116-12,117-22,120-1,121-1,125-1', '2015-06-01 00:00:00', '2015-06-01 07:26:43', 'barman');

-- --------------------------------------------------------

--
-- Table structure for table `Suppliers`
--

CREATE TABLE IF NOT EXISTS `Suppliers` (
  `ID` tinyint(3) NOT NULL COMMENT 'unique ID',
  `Name` varchar(30) NOT NULL COMMENT 'name of the supplier',
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='table that holds data regarding the suppliers';

--
-- Dumping data for table `Suppliers`
--

INSERT INTO `Suppliers` (`ID`, `Name`) VALUES
(1, 'Raiker'),
(2, 'Primator'),
(3, 'In-house'),
(4, 'Lime Kiraly'),
(5, 'Doblo'),
(6, 'Impex 2000 Pohar Center'),
(7, 'Metro'),
(8, 'Rajos'),
(9, 'Svituris');
