<?php
$I = new AcceptanceTester($scenario ?? null);

$I->wantTo("have book's reviews page");

$isbn1="1234567890123";
$BookTitle1="First Book Title";
$BookDescription1="This is very interesting book about life and it's first book ever.";

$id = $I->haveInDatabase('books', ['isbn' =>$isbn1, 'title' => $BookTitle1, 'description' => $BookDescription1]);

$BookId1=$I->grabFromDatabase('books', 'id', [
    'isbn' => $isbn1
]);

$I->amOnPage('/books/'.$BookId1);

$I->fillField('email', 'john.doe@gmail.com');
$I->fillField('password', 'secret');

$I->click('Log in');

$I->amOnPage('/books/'.$BookId1);

$I->click('Reviews');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews');
$I->see('List of '.$BookTitle1."'s reviews.", 'h2');
$I->see('The book has no reviews');

$I->click('Create new...');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/create');
$I->see('Creating a review', 'h2');

$I->click('Create');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/create');
$I->see('The title field is required.', 'li');
$I->see('The text field is required.', 'li');

$ReviewTitle1 = "This is the first review";
$ReviewText1 = "Some random text in first review";

$I->fillField('title', $ReviewTitle1);
$I->fillField('text', $ReviewText1);

$I->click('Create');

$I->seeInDatabase('reviews', [
    'title' => $ReviewTitle1,
    'text' => $ReviewText1
]);

$ReviewId1=$I->grabFromDatabase('reviews', 'id', [
    'title' => $ReviewTitle1
]);

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/'.$ReviewId1);
$I->see($ReviewTitle1, 'h2');
$I->see($ReviewText1);

$isbn2="1234567890124";
$BookTitle2="Second Book Title";
$BookDescription2="This is very interesting book about life and it's second book in this database.";

$id = $I->haveInDatabase('books', ['isbn' =>$isbn2, 'title' => $BookTitle2, 'description' => $BookDescription2]);

$BookId2=$I->grabFromDatabase('books', 'id', [
    'isbn' => $isbn2
]);

$I->amOnPage('/books/'.$BookId2.'/reviews');

$I->see('List of '.$BookTitle2."'s reviews.", 'h2');
$I->see('The book has no reviews');

$I->click('Create new...');

$ReviewTitle2 = "This is the second review";
$ReviewText2 = "Some random text in second review";

$I->fillField('title', $ReviewTitle2);
$I->fillField('text', $ReviewText2);

$I->click('Create');

$ReviewId2=$I->grabFromDatabase('reviews', 'id', [
    'title' => $ReviewTitle2
]);

$I->seeCurrentUrlEquals('/books/'.$BookId2.'/reviews/'.$ReviewId2);
$I->see($ReviewTitle2, 'h2');
$I->see($ReviewText2);

$I->amOnPage('/books/'.$BookId1.'/reviews/'.$ReviewId2);

$I->see('404 Not Found');

$I->amOnPage('/books/'.$BookId1.'/reviews/'.$ReviewId2.'/edit');

$I->see('404 Not Found');

$I->amOnPage('/books/'.$BookId1.'/reviews/'.$ReviewId1);

$I->see($ReviewTitle1, 'h2');
$I->see($ReviewText1);

$I->click('Edit');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/'.$ReviewId1.'/edit');
$I->see('Editing review', 'h2');
$I->seeInField('title', $ReviewTitle1);
$I->seeInField('text', $ReviewText1);

$I->fillField('text', "");

$I->click('Update');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/'.$ReviewId1.'/edit');
$I->see('The text field is required.', 'li');

$ReviewText1Edited="Edited text";

$I->fillField('text', $ReviewText1Edited);

$I->click('Update');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews/'.$ReviewId1);
$I->see($ReviewTitle1, 'h2');
$I->see($ReviewText1Edited);

$I->click('Delete');

$I->seeCurrentUrlEquals('/books/'.$BookId1.'/reviews');

$I->dontSeeInDatabase('reviews', [
    'title' => $ReviewTitle1,
    'text' => $ReviewText1
]);
