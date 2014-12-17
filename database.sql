-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2014 at 06:45 PM
-- Server version: 5.1.63
-- PHP Version: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gaoli_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `0509_article`
--

CREATE TABLE IF NOT EXISTS `0509_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `intro` varchar(255) NOT NULL COMMENT '描述',
  `info` text NOT NULL COMMENT '内容',
  `sort` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `tpl_id` mediumint(8) unsigned NOT NULL COMMENT '模版ID',
  `time_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `time_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `cover` varchar(200) NOT NULL COMMENT '封面',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=292 ;

-- --------------------------------------------------------

--
-- Table structure for table `0509_setting`
--

CREATE TABLE IF NOT EXISTS `0509_setting` (
  `skey` varchar(50) NOT NULL COMMENT '名称',
  `svalue` varchar(255) NOT NULL COMMENT '值',
  UNIQUE KEY `skey` (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置信息表';

-- --------------------------------------------------------

--
-- Table structure for table `0509_tpl`
--

CREATE TABLE IF NOT EXISTS `0509_tpl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '模版名称',
  `flag` varchar(50) NOT NULL COMMENT '模版标记',
  `sort` mediumint(8) unsigned NOT NULL COMMENT '排序',
  `time_add` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `time_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模版信息表' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `0509_user`
--

CREATE TABLE IF NOT EXISTS `0509_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=2 ;
