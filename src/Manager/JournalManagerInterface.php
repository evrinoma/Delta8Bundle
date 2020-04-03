<?php


namespace Evrinoma\Delta8Bundle\Manager;


interface JournalManagerInterface
{
//region SECTION: Public
    public function validate($dataFlow, $date):JournalManagerInterface;
//endregion Public

//region SECTION: Find Filters Repository
    public function findParams():JournalManagerInterface;

    public function findDiscreetInfo():JournalManagerInterface;
//endregion Find Filters Repository

//region SECTION: Getters/Setters
    public function getSettings();
//endregion Getters/Setters
}