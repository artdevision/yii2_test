
ТЕСТОВОЕ ЗАДАНИЕ
-------------------
Необходимо сделать на фреймворке Yii2 + MySQL каталог книг. Книга может иметь несколько авторов.

ТРЕБОВАНИЯ
-------------------
1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
2. Авторы - ФИО.

##### Права доступа
1. Гость - только просмотр + подписка на новые книги автора.
2. Юзер - просмотр, добавление, редактирование, удаление.

Отчет - ТОП 10 авторов выпуствиших больше книг за какой-то год.

Уведомление о поступлении книг из подписки должно отправляться на смс гостю.

СТЕК
------------
yii2, PHP 8.2, PerconaDB

УСТАНОВКА
------------
```shell
cd {project_dir}
cp .env.example .env
cp docker-compose.yml.example docker-compose.local.yml
docker-compose up -d --build
docker-compose exec fpm compose install
docker-compose exec fpm php yii migrate
# Заполнение тестовыми пользователями admin/admin demo/demo
docker-compose exec fpm php yii init/index
```

РОУТЫ
------------
- `{base_url}/author/index`
- `{base_url}/author/create?id={id}`
- `{base_url}/author/update?id={id}`
- `{base_url}/author/delete?id={id}`
- `{base_url}/author/top?year={?year}`
- `{base_url}/book/index`
- `{base_url}/book/create?id={id}`
- `{base_url}/book/update?id={id}`
- `{base_url}/book/delete?id={id}`
- `{base_url}/subscription/subscribe?author_id={author_id}`



