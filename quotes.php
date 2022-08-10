<?php
/**
 * TO STORE QUOTES RELATED TO MEDIAS AND GET RANDOM QUOTE FOR EACH MEDIA TO DISPLAY ON OTHER PAGES. 
 *
 * @version    PHP 8.0.12 
 * @since      July 2022
 * @author     AtharvaShah
 */

$bookquotes=[
    "Nothing is insoluble. Nothing is hopeless. Not while there's life. -  Alan Moore",
    "So many books, so little time.-  Frank Zappa",
    "It's the possibility of having a dream come true that makes life interesting. - Paulo Coelho",
    "What's the point of having a voice if you're gonna be silent in those moments you shouldn't be? - Angie Thomas",
    "Too much sanity may be madness — and maddest of all: to see life as it is, and not as it should be! - Miguel de Cervantes Saavedra",
    "That's the thing about books. They let you travel without moving your feet. - Jhumpa Lahiri",
    "Not all those who wander are lost. - J.R.R. Tolkein",
    “Those who don’t believe in magic will never find it. — Roald Dahl",
    “It is better to be hated for what you are than to be loved for what you are not. - André Gide",
    “The worst enemy to creativity is self-doubt. - Sylvia Plath",
    “Even the darkest night will end and the sun will rise. - Victor Hugo",
    “To choose doubt as a philosophy of life is akin to choosing immobility as a means of transportation. - Yann Martel",
    "Happiness can be found even in the darkest of times, if one only remembers to turn on the light. - J.K. Rowling",
    “We can know only that we know nothing. And that is the highest degree of human wisdom. ― Leo Tolstoy",
    "There is no Friend as Loyal as a Book – Ernest Hemingway",

    //add 13 more quotes here
];

$moviequotes=[
   “A wise man can learn more from his enemies than a fool from his friends. – Niki Lauda",
   “Every man dies, but not every man really lives. – William Wallace",
   “Don’t let anyone ever make you feel like you don’t deserve what you want. – Heath Ledger",
   “Great men are not born great, they grow great. – Mario Puzo",
   “It’s what you do right now that makes a difference. – Struecker",
   “Just because someone stumbles and loses their path, doesn’t mean they’re lost forever. - Professor X",
   “Life is not the amount of breaths you take. It’s the moments that take your breath away. – Alex Hitchens",
   “Life moves pretty fast. If you don’t stop and look around once in a while, you could miss it. – Ferris Bueller",
   “Our lives are defined by opportunities, even the ones we miss. – Benjamin Button",
   “Our lives are not fully lived if we’re not willing to die for those we love, for what we believe. – Martin Luther King Jr.",
   “Sometimes it is the people who no one imagines anything of who do the things that no one can imagine. – Alan Turing",
   “If you focus on what you left behind, you will never be able to see what lies ahead. - Gusteau",
   “The very things that hold you down are going to lift you up. - Timothy Mouse",
   “All we have to decide is what to do with the time that is given to us. - Gandalf",
   “Carpe diem. Seize the day, boys. Make your lives extraordinary. - John Keating",

   
    //add 14 more quotes here
];


$tvquotes=[
    "Quote - Show Name",
    //add 14 more quotes here
];


$videogamequotes=[
    "Quote - Game Name",
    //add more quotes here
];


$albumquotes=[
    "Quote - Artist Name",
    //add 14 more quotes here
];


echo $bookquotes[array_rand($bookquotes)];
echo $moviequotes[array_rand($moviequotes)];
echo $tvquotes[array_rand($tvquotes)];
echo $videogamequotes[array_rand($videogamequotes)];
echo $albumquotes[array_rand($albumquotes)];
?>
