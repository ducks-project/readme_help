# ROADMAP

* Create a search Component and use it in Search Service
* Use state for Operator selection (BO) in order to hide pattern for example
* Use link instead of button for EntityBundleSelectionFormTrait
* !Important! /vente-location/ works (it should return a 404 because it's /vente--location/) -> redirect temporaire? (ou 404 configurable?)

* IDEA:
- Create a "proxy" (not really a proxy)
-> __get on SearchEntity
->> This method try to Search a referenced class (plugin?) corresponding to the arg.
example:
$search_entity = SearchEntity::create();
$breadcrumb = $search_entity->getBreadcrumb(); // return a new Class BreadcrumbThirdsSettings (example name)
$breadcrumb->getActive(); // return only active parameters.
