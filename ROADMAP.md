# Project roadmap

## Prepare core
- [ ] Integrations
  - [x] Firm should become part of access token scope
  - [x] Send token just after integration installed
  - [x] Integration can upload own javascript to interact with interface
  - [ ] Signed token
- [ ] Event log
  - [ ] WebHooks
  - [ ] Signed WebHooks
  - [ ] Setup WebHooks escalation & rules
- [ ] OAuth
  - [ ] Callback url when token revoked
  - [x] One time token
  - [ ] [Purge old tokens](https://laravel.com/docs/8.x/passport#events)
  - [x] [Edit authorization view](https://laravel.com/docs/8.x/passport#approving-the-request)
  - [ ] Rewrite dynamic scopes functionality with classes
  - [x] Check if access policy applied for passport oauth clients routes
  - [x] Close all unused passport functionality (except 'AuthorizationController@authorize')
- [ ] Review make:enhanced:* commands
- [ ] ZenMoney integration
  - [ ] From ZenMoney to app
    - [ ] Accounts
    - [ ] Transactions
  - [ ] From app to ZenMoney 
    - [ ] Accounts
    - [ ] Transactions
- [ ] i18n integration
- [ ] Replace native docker integration with more flexible solution
- [ ] Rights
  - [ ] Departments
  - [ ] RBAC
- [ ] Transactions management
    - [ ] Users can manage their transactions
- [ ] Analise
- [ ] Budget planning
- [ ] Emails templates

## Plans in big future
- [ ] Bonds
- [ ] ETF
- [ ] Stocks
- [ ] Keep all exchange instruments in one place
- [ ] Integration JavaScript in application

## Final mission

Manage all financial flows in one place,
we help you choose the best strategy
without going into details.
