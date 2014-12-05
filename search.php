<section id="sitemap" class="blue-box" >
    <form name="searchForm" >
        <fieldset>
            <input type="url" name="url" placeholder="URL de votre sitemap au format xml" ng-model="search.url" required>
            <input style="color:#365D95" ng-click="addSearch(searchForm)" class="btn right" type="submit" value="VALIDER">
        </fieldset>
    </form>
	<div id="progress" ng-show="urls.length">
		<div class="row">
			<div class="col-md-10">
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{progress}}%">
			  	{{progress | number :0}}%
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-danger btn-sm" ng-hide="progress == 100 || pause == 1" ng-show="progress != 100 && pause == 0" ng-click="stop()">PAUSE</button>
				<button type="button" class="btn btn-success btn-sm" ng-hide="pause == 0" ng-show="pause == 1" ng-click="stop()">PLAY</button>
			</div>
		</div>
	</div>
</section>
<div id="message" class="alert alert-danger alert-dismissible" role="alert" ng-show="message.length">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
  <strong>{{message}}</strong>
</div>
<section>
	<div class="result blue-box" ng-show="urls.length">
		<div class="row tb-result bg-primary">
			<div class="col-md-7">URL de la page [{{key}}/{{sitemap.length}}] <span ng-show="nonTraite > 0">dont {{nonTraite}} non traité(s)</span></div>
			<div class="col-md-1">W3C</div>
			<div class="col-md-2">Erreurs</div>
			<div class="col-md-2">Warning</div>
		</div>
		<div class="row tb-result" ng-repeat="url in urls track by $index">
			<div id="accordion">
				<div class="col-md-7 pad5 text-left" ng-class="getClass(url.erreurs.length, url.warnings.length)">
					<a ng-href="{{url.loc}}" target="_blank">
						{{url.loc}}
					</a>
				</div>
				<div class="col-md-1 pad5" ng-class="getClass(url.erreurs.length, url.warnings.length)">
					<a href="#" class="btn btn-primary btn-sm" role="button"
					ng-href="http://validator.w3.org/check?uri={{url.loc}}&charset=(detect+automatically)&doctype=Inline&group=0&user-agent=W3C_Validator/1.3+http://validator.w3.org/services" target="_blank" >W3C</a>
				</div>
				<div class="col-md-2 pad5" ng-class="getClass(url.erreurs.length, url.warnings.length)">
					<button type="button" class="btn btn-danger btn-sm"  disabled="disabled" ng-show="url.erreurs.length == 0">Aucune erreur</button>
					<button id="$index" type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-parent="#accordion" ng-href="#erreur{{$index}}" ng-show="url.erreurs.length" ng-click="changeClassError($index)" ng-class="{active: value['error'][$index] == $index}">
						{{url.erreurs.length}} Erreur(s)
					</button>
				</div>
				<div class="col-md-2 pad5" ng-class="getClass(url.erreurs.length, url.warnings.length)">
					<button type="button" class="btn btn-warning btn-sm"  disabled="disabled" ng-show="url.warnings.length == 0">Aucun warning</button>
					<button id="$index" type="button" class="btn btn-warning btn-sm" data-toggle="collapse" data-parent="#accordion" ng-href="#warning{{$index}}" ng-show="url.warnings.length" ng-click="changeClassWarning($index)" ng-class="{active: value['warning'][$index] == $index}">
						{{url.warnings.length}} Warning(s)
					</button>
				</div>
				<div class="col-md-12 container-fluid collapse" id="erreur{{$index}}" ng->
					<div class="row tb-result bg-danger" ng-repeat="erreur in url.erreurs">
						<div class="col-md-2">{{erreur.ligne}}</div>
						<div class="col-md-3">{{erreur.titre}}</div>
						<div class="col-md-7"><kbd>{{erreur.code}}</kbd></div>
					</div>
				</div>
				<div class="col-md-12 container-fluid collapse" id="warning{{$index}}">
					<div class="row tb-result bg-warning" ng-repeat="warning in url.warnings">
						<div class="col-md-12">{{warning.titre}}</div>
						<div class="col-md-12">{{warning.descr}}</div>
						<div class="col-md-12">{{warning.list}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>