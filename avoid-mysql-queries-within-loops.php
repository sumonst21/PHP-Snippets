<?php
// the right way
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
