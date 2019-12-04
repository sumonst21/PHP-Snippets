<?php
// the right way

/*

//example mysql table
CREATE TABLE `person` (
`ID` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 30 ) NOT NULL
);
CREATE TABLE `colour` (
`ID` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`personID` INT( 5 ) NOT NULL ,
`colour` VARCHAR( 30 ) NOT NULL
);

INSERT INTO `person` (`ID`, `name`) VALUES (NULL, 'Michael'), (NULL, 'Alyshea');
INSERT INTO `person` (`ID`, `name`) VALUES (NULL, 'Frank'), (NULL, 'Jim');
INSERT INTO `colour` (`ID`, `personID`, `colour`) VALUES (NULL, '1', 'Blue'), (NULL, '1', 'Black');
INSERT INTO `colour` (`ID`, `personID`, `colour`) VALUES (NULL, '2', 'Pink'), (NULL, '3', 'Green');
INSERT INTO `colour` (`ID`, `personID`, `colour`) VALUES (NULL, '3', 'Brown'), (NULL, '4', 'Yellow');

*/
// Query for all the people
$queryPeople = mysql_query("SELECT * FROM person") or die(mysql_error());

// Loop through each row
while($person = mysql_fetch_array($queryPeople))
{
// Put the person into an array using their ID as the array key
$arrayPeople[$person['ID']] = $person;
}

// Query for all the colours
$queryColours = mysql_query("SELECT * FROM colour");
while($colour = mysql_fetch_array($queryColours))
{
// Attach the colour onto the $arrayPeople array
// We can do this because we know the personID from the colour table
$arrayPeople[$colour['personID']]['colours'][] = $colour;
}

// Loop through each person
foreach($arrayPeople AS $person)
{
// Display the persons name
echo "
" . $person['name'] . "
";

// Loop through every colour
foreach($person['colours'] AS $colour)
{
// Display the colour
echo $colour['colour'] . "
";
}
}
// src: https://www.zope-europe.org/avoid-mysql-queries-within-loops/
