#####
Локально можно развернуть с помощью `Docker` (а именно с использованием `sail`)
Для простоты исполнения команд добавлен `Makefile`
- Установка:
1. Билд проекта
```bash
make build
```
Остальные команды можно посмотреть в `Makefile`
> NOTE: если билд не проходит, стоит попробовать выполнить первую команду из `make build` вручную, заменив `$(shell pwd)` на `$(pwd)`, и убрав эту команду из `make build`

- Путь к документации
```bash
{{host}}/api/documentation
```
Например `http://localhost:81/api/documentation`
