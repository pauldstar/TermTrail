<?php
include_once 'header.php';

echo "
<div style='height:600px'>
  <div class='container indexTopDiv' id='firstDiv'>
    <h1 class='text-center' id='slogan'>SETTING UP DATABASE!</h1>
    <ul class='text-center myWhiteText' style='list-style-type: none; font-size: large'>";

createTable(
  'user','
  userID INT AUTO_INCREMENT NOT NULL,
  username VARCHAR(50) NOT NULL,
  passwordHash VARCHAR(40) NOT NULL,
  userType VARCHAR(20) NOT NULL,
  email VARCHAR(255) NOT NULL,
  firstName VARCHAR(50) NOT NULL,
  surname VARCHAR(50) NOT NULL,
  signUpTime BIGINT UNSIGNED NOT NULL,
  lastLoginTime BIGINT UNSIGNED NOT NULL,
  profilePicture VARCHAR(40),
  profileViews BIGINT UNSIGNED DEFAULT 0,
  dateOfBirth DATE NOT NULL,
  country VARCHAR(100) NOT NULL,
  city VARCHAR(100) NOT NULL,
  explorerPoints INT UNSIGNED,
  explorerLevel MEDIUMINT UNSIGNED,
  explorerRank VARCHAR(20),
  explorerDiscoveries INT,
  explorerSubscribers INT,
  explorerSubscriptions INT,
  explorerReferredDiscoveries BIGINT UNSIGNED,
  explorerReferredLinkClicks BIGINT UNSIGNED,
  clientBusinessName VARCHAR(50),
  clientCategory VARCHAR(50),
  clientDescription TINYTEXT,
  clientDiscovered BIGINT UNSIGNED,
  clientLinkClicks BIGINT UNSIGNED,
  currentPennies MEDIUMINT DEFAULT 0,
  totalPenniesEver INT DEFAULT 0,
  INDEX(profileViews),
  INDEX(explorerDiscoveries),
  INDEX(explorerSubscribers),
  INDEX(explorerReferredDiscoveries),
  INDEX(explorerReferredLinkClicks),
  INDEX(clientDiscovered),
  INDEX(clientCategory),
  INDEX(clientLinkClicks),
  INDEX(explorerPoints),
  INDEX(totalPenniesEver),
  INDEX(userName),
  INDEX(firstName),
  INDEX(surname),
  INDEX(country),
  INDEX(city),
  PRIMARY KEY(userID)');

createTable(
  'link','
  url VARCHAR(500) NOT NULL,
  client INT NOT NULL,
  linkType VARCHAR(20) NOT NULL,
  clicked BIGINT UNSIGNED DEFAULT 0,
  timeAdded BIGINT UNSIGNED NOT NULL,
  rate TINYINT UNSIGNED DEFAULT 0,
  FOREIGN KEY(client) REFERENCES user(userID),
  PRIMARY KEY(url, client)');

createTable(
  'click','
  clickID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  timeAdded BIGINT UNSIGNED NOT NULL,
  clickerType VARCHAR(20) NOT NULL,
  user INT,
  clickType VARCHAR(20) NOT NULL,
  url VARCHAR(500) NOT NULL,
  owner INT NOT NULL,
  referredBy INT,
  FOREIGN KEY(url, owner) REFERENCES link(url, client),
  FOREIGN KEY(user) REFERENCES user(userID),
  FOREIGN KEY(referredBy) REFERENCES user(userID),
  PRIMARY KEY(clickID)');

createTable(
  'accountActivity','
  timeAdded BIGINT UNSIGNED NOT NULL,
  user INT NOT NULL,
  actionType VARCHAR(20) NOT NULL,
  penniesUsed MEDIUMINT NOT NULL,
  FOREIGN KEY(user) REFERENCES user(userID),
  PRIMARY KEY(user, timeAdded)');
  
createTable(
  'subscription','
  discoverer INT NOT NULL,
  subscriber INT NOT NULL,
  timeAdded BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY(discoverer) REFERENCES user(userID),
  FOREIGN KEY(subscriber) REFERENCES user(userID),
  PRIMARY KEY(discoverer, subscriber)');

createTable(
  'referral','
  signUpCode VARCHAR(50) NOT NULL,
  referrer INT NOT NULL,
  newUser INT,
  timeAdded BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY(referrer) REFERENCES user(userID),
  FOREIGN KEY(newUser) REFERENCES user(userID),
  PRIMARY KEY(signUpCode)');
echo "</ul></div></div>";

include_once 'footer.php';