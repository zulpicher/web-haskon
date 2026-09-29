# File Tree: web_haskon

**Generated:** 9/29/2026, 1:26:00 PM
**Root Path:** `/persistent/home/zul/Projects/web_haskon`

```
├── app
│   ├── Exports
│   │   └── TransactionReportExport.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   └── GroupController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── BukuKasController.php
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ReportController.php
│   │   │   ├── TaskCommentController.php
│   │   │   ├── TaskController.php
│   │   │   └── TransactionController.php
│   │   ├── Middleware
│   │   │   └── EnsureUserIsAdmin.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       ├── ProfileUpdateRequest.php
│   │       ├── TaskRequest.php
│   │       └── TransactionRequest.php
│   ├── Models
│   │   ├── Group.php
│   │   ├── Task.php
│   │   ├── TaskComment.php
│   │   ├── Transaction.php
│   │   └── User.php
│   ├── Providers
│   │   └── AppServiceProvider.php
│   ├── Services
│   │   ├── CashBalanceService.php
│   │   └── ReportService.php
│   └── View
│       └── Components
│           ├── AppLayout.php
│           └── GuestLayout.php
├── bootstrap
│   ├── app.php
│   └── providers.php
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_09_09_012257_create_transactions_table.php
│   │   ├── 2026_09_18_082649_create_groups_table.php
│   │   ├── 2026_09_18_082714_create_group_user_table.php
│   │   ├── 2026_09_18_082725_add_role_to_users_table.php
│   │   ├── 2026_09_18_082740_create_tasks_table.php
│   │   ├── 2026_09_18_082754_create_task_comments_table.php
│   │   ├── 2026_09_21_083450_change_roles_in_users_table.php
│   │   ├── 2026_09_21_083734_change_task_status_enum.php
│   │   ├── 2026_09_28_031144_create_task_user_table.php
│   │   └── 2026_09_28_031835_remove_assigned_to_from_tasks_table.php
│   ├── seeders
│   │   └── DatabaseSeeder.php
│   ├── .gitignore
│   └── database.sqlite
├── docker
│   └── nginx
│       └── default.conf
├── public
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
├── resources
│   ├── css
│   │   ├── modules
│   │   │   └── buku-kas.css
│   │   └── app.css
│   ├── images
│   │   └── logo_haskon.svg
│   ├── js
│   │   ├── modules
│   │   │   ├── buku-kas.js
│   │   │   └── task.js
│   │   └── app.js
│   └── views
│       ├── admin
│       │   └── groups
│       │       ├── create.blade.php
│       │       ├── edit.blade.php
│       │       └── index.blade.php
│       ├── auth
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── buku-kas
│       │   ├── components
│       │   │   ├── modals
│       │   │   │   ├── add.blade.php
│       │   │   │   ├── delete.blade.php
│       │   │   │   ├── detail.blade.php
│       │   │   │   ├── edit.blade.php
│       │   │   │   └── history.blade.php
│       │   │   ├── financial-activity.blade.php
│       │   │   ├── recent-transactions.blade.php
│       │   │   └── summary.blade.php
│       │   └── dashboard.blade.php
│       ├── components
│       │   ├── application-logo.blade.php
│       │   ├── auth-session-status.blade.php
│       │   ├── danger-button.blade.php
│       │   ├── dropdown-link.blade.php
│       │   ├── dropdown.blade.php
│       │   ├── input-error.blade.php
│       │   ├── input-label.blade.php
│       │   ├── modal.blade.php
│       │   ├── nav-link.blade.php
│       │   ├── primary-button.blade.php
│       │   ├── responsive-nav-link.blade.php
│       │   ├── secondary-button.blade.php
│       │   └── text-input.blade.php
│       ├── layouts
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── profile
│       │   ├── partials
│       │   │   ├── delete-user-form.blade.php
│       │   │   ├── update-password-form.blade.php
│       │   │   └── update-profile-information-form.blade.php
│       │   └── edit.blade.php
│       ├── reports
│       │   ├── index.blade.php
│       │   └── pdf.blade.php
│       ├── tasks
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── home.blade.php
│       └── welcome.blade.php
├── routes
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── storage
│   ├── app
│   │   ├── private
│   │   │   └── .gitignore
│   │   ├── public
│   │   │   ├── task-comments
│   │   │   │   ├── 8P69QPOcAbH6WjbkXoPNKM43LueFOGEPdxdf6JEb.jpg
│   │   │   │   └── VdqEpiUm7C6qyzGADiw73BSRMBARa6O48icnrFMu.pdf
│   │   │   └── .gitignore
│   │   └── .gitignore
│   ├── framework
│   │   ├── sessions
│   │   │   └── .gitignore
│   │   ├── testing
│   │   │   ├── .gitignore
│   │   │   └── _pest.php
│   │   ├── views
│   │   │   ├── .gitignore
│   │   │   ├── 08753f8b4c7bcd91c76536d3821618bd.php
│   │   │   ├── saya potong biar g kebanyakan
│   │   ├── .gitignore
│   │   └── lsp-73727eb9e7630875.php
│   └── logs
│       └── .gitignore
├── tests
│   ├── Feature
│   │   ├── Auth
│   │   │   ├── AuthenticationTest.php
│   │   │   ├── EmailVerificationTest.php
│   │   │   ├── PasswordConfirmationTest.php
│   │   │   ├── PasswordResetTest.php
│   │   │   ├── PasswordUpdateTest.php
│   │   │   └── RegistrationTest.php
│   │   ├── ExampleTest.php
│   │   └── ProfileTest.php
│   ├── Unit
│   │   └── ExampleTest.php
│   ├── Pest.php
│   └── TestCase.php
├── .dockerignore
├── .editorconfig
├── .env.example
├── .gitattributes
├── .gitignore
├── .mcp.json
├── .npmrc
├── AGENTS.md
├── CLAUDE.md
├── Dockerfile
├── README.md
├── artisan
├── boost.json
├── composer.json
├── docker-compose.yml
├── package-lock.json
├── package.json
├── phpunit.xml
├── postcss.config.js
├── readmehaskon.md
├── tailwind.config.js
└── vite.config.js
```

---
*Generated by FileTree Pro Extension*