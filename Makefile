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