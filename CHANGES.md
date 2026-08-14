# 📋 Журнал улучшений проекта GameApp

**Разработчик:** Дуплей Максим Игоревич  
**Дата:** 15 июля 2026

---

## ✅ Исправленные баги

### 1. Ошибка в `index.blade.php`
- **Проблема:** Использовалось `$post->content`, но поле в модели называется `body`
- **Решение:** Заменено на `$post->body`

### 3. Несоответствие таблиц в отношениях
- **Проблема:** В `Tag.php` указана таблица `post_tag`, а в `Post.php` — `post_tags`
- **Решение:** Исправлено в `Tag.php` на `post_tags` с правильными внешними ключами

### 4. Похожие посты могли включать сам пост (14 августа 2026)
- **Проблема:** `orWhereHas('tags')` находился вне группы `where(...)`, из-за чего фильтр `id != post->id` игнорировался
- **Решение:** Запрос обёрнут в `where(function ($q) { $q->where(...)->orWhereHas(...) })` в `PostController::show`

### 5. Ошибка компиляции профиля (14 августа 2026)
- **Проблема:** В кнопках вкладок профиля не закрывалась директива `{{ }}` в атрибуте `class`, из-за чего Blade «проглатывал» последующие строки — страница падала с ParseError
- **Решение:** Добавлены закрывающие `}}`, а доступ к computed-свойствам в шаблоне заменён на `$this->posts` / `$this->bookmarks` / `$this->reactions` / `$this->achievements`
- **Обнаружено:** новый тест `ProfileTest` — страница профиля ранее не покрывалась тестами

---

## 🆕 Добавленный функционал

### 1. 👍👎 Система реакций (Лайки/Дизлайки) — 16 июля 2026

**Файлы:**
- `database/migrations/2026_07_16_193306_create_reactions_table.php` — миграция
- `app/Models/Reaction.php` — модель
- `app/Models/User.php` — добавлены отношения и методы реакций
- `app/Models/Post.php` — добавлены связи и счётчики реакций
- `app/Livewire/ToggleReaction.php` — Livewire компонент
- `resources/views/livewire/toggle-reaction.blade.php` — view компонента

**Возможности:**
- Лайки и дизлайки для каждого поста
- Livewire компонент без перезагрузки страницы
- Взаимоисключение: при добавлении лайка дизлайк снимается и наоборот
- Счётчики лайков и дизлайков для каждого поста
- Уникальность: одна реакция одного типа на один пост от одного пользователя
- Метод `reactionScore()` — разница лайков и дизлайков

**Методы в `User`:**
- `hasReacted(Post $post, string $type)` — проверить реакцию
- `react(Post $post, string $type)` — добавить реакцию
- `removeReaction(Post $post, string $type)` — удалить реакцию

**Методы в `Post`:**
- `likesCount()` — количество лайков
- `dislikesCount()` — количество дизлайков
- `reactionScore()` — разница лайков и дизлайков

---

### 2. 🔍 Система поиска и фильтрации постов

**Файлы:**
- `app/Http/Controllers/Post/PostController.php` — обновлён метод `index()`
- `resources/views/pages/posts/index.blade.php` — добавлена форма фильтров

**Возможности:**
- Поиск по заголовку, тексту и описанию поста
- Фильтрация по категориям
- Фильтрация по тегам
- Сортировка: по дате (новые первые), по популярности, по алфавиту
- Отображение активных фильтров
- Кнопка сброса фильтров

---

### 2. ⭐ Система избранного (Bookmarks)

**Файлы:**
- `database/migrations/2026_07_15_120608_create_bookmarks_table.php` — миграция
- `app/Models/Bookmark.php` — модель
- `app/Models/User.php` — добавлены отношения и методы
- `app/Models/Post.php` — добавлены связи и счётчики
- `app/Livewire/ToggleBookmark.php` — Livewire компонент
- `resources/views/livewire/toggle-bookmark.blade.php` — view компонента

**Возможности:**
- Добавление/удаление поста из избранного одним кликом
- Livewire компонент без перезагрузки страницы
- Счётчик отметок для каждого поста
- Уникальность: один пост не может быть добавлен дважды

**Методы в `User`:**
- `hasBookmarked(Post $post)` — проверить, добавлен ли пост
- `bookmark(Post $post)` — добавить в избранное
- `removeBookmark(Post $post)` — удалить из избранного

---

### 3. 👤 Профиль пользователя

**Файлы:**
- `app/Livewire/UserProfile.php` — Livewire компонент профиля
- `resources/views/livewire/user-profile.blade.php` — view профиля

**Возможности:**
- Аватар с инициалами пользователя
- Статистика: посты, комментарии, избранное
- Вкладки: посты пользователя / избранное
- Пагинация в каждой вкладке
- Просмотр профилей других пользователей (`/profile/{user}`)

**Методы в `User`:**
- `getStats()` — получить статистику пользователя
- `posts()` — связь с постами
- `comments()` — связь с комментариями
- `bookmarks()` — связь с избранным

---

### 4. 🗺 Обновлённые маршруты

**Файл:** `routes/web.php`

**Добавлено:**
- `GET /profile` — профиль текущего пользователя
- `GET /profile/{user}` — просмотр профиля другого пользователя
- `POST /posts/{post}/bookmark` — переключатель избранного

---

### 5. 🌱 Seeder для тестовых данных

**Файл:** `database/seeders/GameAppSeeder.php`

**Создаёт:**
- 5 тестовых пользователей
- 9 категорий (Новости, Обзоры, Гайды, Инде-игры, Киберспорт, Железо и др.)
- 10 тегов (RPG, FPS, Strategy, Indie и др.)
- 6 постов с полным текстом
- Комментарии к постам
- Тестового администратора: `admin@gameapp.local` / `password`

**Запуск:**
```bash
php artisan db:seed --class=GameAppSeeder
```

---

### 6. 🎨 Обновлённый интерфейс

**Файл:** `resources/views/partials/header.blade.php`

**Изменения:**
- Добавлена ссылка на профиль пользователя
- Обновлена навигация в шапке

---

### 7. 🏆 Система рангов и достижений (14 августа 2026)

**Файлы:**
- `database/migrations/2026_08_14_000001_add_rank_id_to_users_table.php` — миграция (FK `rank_id` → `user_ranks`)
- `app/Models/UserRank.php`, `app/Models/Achievement.php` — модели
- `database/seeders/UserRankSeeder.php` — 5 рангов
- `database/seeders/AchievementSeeder.php` — 8 достижений
- `app/Services/AchievementService.php` — сервис синхронизации достижений
- `app/Models/User.php` — связь `rank()`, метод `assignRank()`
- `app/Livewire/UserProfile.php`, `resources/views/livewire/user-profile.blade.php` — бейдж ранга, прогресс-бар, вкладка «Достижения»
- `database/factories/AchievementFactory.php`, `database/factories/UserRankFactory.php` — фабрики
- `tests/Feature/AchievementTest.php`, `tests/Feature/UserRankTest.php`, `tests/Feature/ProfileTest.php` — тесты

**Ранги:**
- 🎮 Новичок → ✍️ Автор → 💬 Активный участник → 🏆 Эксперт → 👑 Легенда
- Ранг повышается автоматически при создании постов, комментариев и реакций (метод `assignRank()`)

**Достижения:**
- posts_1 / posts_10 / posts_25 — количество постов
- comments_1 / comments_50 — количество комментариев
- reactions_1 / reactions_100 — количество реакций
- bookmarks_10 — количество избранного

**Возможности:**
- Бейдж ранга и прогресс-бар «до следующего ранга» в профиле
- Вкладка «Достижения» с иконками и статусом «Получено/Заблокировано»
- `AchievementService::sync(User)` вызывается в `PostController::store`, `CommentController::store`, `ToggleReaction`, `ToggleBookmark`

### 8. 🧹 Качество кода: phpstan 69 → 0 ошибок (14 августа 2026)

**Исправлено:**
- Добавлены generic-аннотации всем моделям и Livewire-компонентам (phpstan уровень 6)
- `StoreCommentRequest` — корректное сужение типа из `route('comment')`
- `UserFactory::withTwoFactor()` — добавлено состояние вместо пустого тела
- `PostTagsSeeder` — баг `count(1,4)` → `random(rand(1,4))`
- `NotificationService::commentLiked()` — корректная типизация параметров
- Добавлены фабрики `BookmarkFactory`, `PostTagFactory`, `AchievementFactory`, `UserRankFactory`

---

## 📁 Новая структура файлов

```
app/
├── Livewire/
│   ├── ToggleBookmark.php      ← Новый компонент
│   └── UserProfile.php         ← Новый компонент
├── Models/
│   ├── Bookmark.php            ← Новая модель
│   ├── Post.php                ← Обновлена
│   └── User.php                ← Обновлена

database/
├── migrations/
│   └── 2026_07_15_120608_create_bookmarks_table.php ← Новая
└── seeders/
    └── GameAppSeeder.php       ← Новый

resources/
└── views/
    ├── livewire/               ← Новая директория
    │   ├── toggle-bookmark.blade.php
    │   ├── post-filter.blade.php
    │   └── user-profile.blade.php
    └── pages/
        └── posts/
            └── index.blade.php  ← Обновлена

routes/
└── web.php                     ← Обновлён
```

---

## 🚀 Быстрый старт

1. **Миграции:**
   ```bash
   php artisan migrate --force
   ```

2. **Заполнение тестовыми данными:**
   ```bash
   php artisan db:seed --class=GameAppSeeder
   ```

3. **Запуск сервера:**
   ```bash
   php artisan serve
   ```

4. **Админ-аккаунт:**
   - Email: `admin@gameapp.local`
   - Пароль: `password`

---

## 📊 Итоговая статистика

| Показатель | Значение |
|-----------|----------|
| Исправлено багов | 2 |
| Добавлено миграций | 5 |
| Добавлено моделей | 5 |
| Обновлено моделей | 3 |
| Добавлено Livewire компонентов | 5 |
| Добавлено seeders | 1 |
| Обновлено контроллеров | 2 |
| Добавлено маршрутов | 3 |
| Обновлено view файлов | 10 |

---

## 🎯 Что можно добавить в будущем

- [x] Система уведомлений
- [x] Лайки/дизлайки постов
- [x] Лайки для комментариев
- [x] Популярные посты на главной
- [x] Облако тегов на главной
- [ ] Экспорт постов в PDF
- [x] SEO мета-теги
- [ ] Тёмная/светлая тема
- [ ] REST API
- [x] Подписки на авторов
- [x] Ранги и достижения пользователей
