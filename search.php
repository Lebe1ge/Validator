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
		<div class="row tb-result bg-danger" ng-repeat="url in urls track by $index">
			<div>
				<div class="col-md-6">{{url.loc}}</div>
				<div class="col-md-3 { active:isSet_err($index) }">
					<a href ng-click="setTab_err($index)">{{url.erreurs.length}} Erreurs</a>
				</div>
				<div class="col-md-3 { active:isSet_warn($index) }">
					<a href ng-click="setTab_warn($index)">{{url.warnings.length}} Warning</a>
				</div>
				<div class="col-md-12 container-fluid" ng-show="isSet_err($index)">
					<div class="row tb-result bg-danger" ng-repeat="erreur in url.erreurs">
						<div class="col-md-2">{{erreur.ligne}}</div>
						<div class="col-md-3">{{erreur.titre}}</div>
						<div class="col-md-7"><code>{{erreur.code}}</code></div>
					</div>
				</div>
				<div class="col-md-12 container-fluid" ng-show="isSet_warn($index)">
					<div class="container-fluid" ng-show="isSet_warn($index)">
						<div class="row tb-result bg-warning" ng-repeat="warning in url.warnings">
							<div class="col-md-2">{{warning.titre}}</div>
							<div class="col-md-3">{{warning.descr}}</div>
							<div class="col-md-7">{{warning.list}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>