dev:
	make -j 2 artisan-serve vuejs
artisan-serve:
	cd GameSaga && php artisan serve
vuejs:
	cd GameSagaFront && npm run dev
test:
	cd GameSaga && php artisan migrate:fresh --seed
	cd ..
	cd Tests && npm run tests
init-publish:
	docker context create gamesaga --docker "host=ssh://ubuntu@46.105.31.136"
	docker context use gamesaga
publish:
	docker context use gamesaga
	docker-compose down --rmi all --remove-orphans
	docker system prune -a
	docker compose -f ./docker-stack.yml up -d
	timeout 20
	docker exec $(shell docker ps --filter "name=projetgamesaga-laravel-docker-1" --quiet) bash -c "php artisan migrate:fresh --seed"
publish-data:
	docker exec $(shell docker ps --filter "name=projetgamesaga-laravel-docker-1" --quiet) bash -c "php artisan migrate:fresh --seed"