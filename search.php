<section id="sitemap" class="blue-box" >
    <form name="searchForm" >
        <fieldset>
            <input type="url" name="url" placeholder="URL de votre sitemap au format xml" ng-model="search.url" required>
            <input style="color:#365D95" ng-click="addSearch(searchForm)" class="btn right" type="submit" value="VALIDER">
        </fieldset>
    </form>
</section>
<section>
                <div class="result blue-box" ng-show="urls.length">
                    <div class="row tb-result bg-primary">
                        <div class="col-md-6">URL de la page</div>
                        <div class="col-md-3">Erreurs</div>
                        <div class="col-md-3">Warning</div>
                    </div>
                    <div class="row tb-result bg-danger" ng-repeat="url in urls">
                        <div class="col-md-6">{{url.loc}}</div>
                        <div class="col-md-3">{{url.errors.length}} Erreurs</div>
                        <div class="col-md-3">{{url.warnings.length}} Warning</div>
                        <div class="container-fluid">
                            <div class="row tb-result bg-danger" ng-repeat="error in url.errors">
                                <div class="col-md-2">{{error.emplacement}}</div>
                                <div class="col-md-3">{{error.def}}</div>
                                <div class="col-md-7">{{error.ligne}}</div>
                            </div>
                            <div class="row tb-result bg-warning" ng-repeat="warning in url.warnings">
                                <div class="col-md-2">{{warning.emplacement}}</div>
                                <div class="col-md-3">{{warning.def}}</div>
                                <div class="col-md-7">{{warning.ligne}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>