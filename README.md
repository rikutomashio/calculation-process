# Calculation Process

## 概要

Laravel 8で実装したマンガ喫茶の料金計算システムです。

入店時間・退店時間・コースをもとに、基本料金・延長料金・深夜料金・消費税を計算します。

---

## 機能

- コース料金計算
- 延長料金計算（10分単位・切り上げ）
- 深夜延長料金計算（22:00以降の延長料金に15%割増）
- 税込・税抜金額の算出
- Unitテストによる動作確認

---

## 使用技術

- PHP
- Laravel 8
- Docker
- PHPUnit

---

## ディレクトリ構成

```
src
├── app
│   ├── Enums
│   │   └── CourseType.php
│   └── Services
│       └── CafeFeeCalculator.php
│
└── tests
    └── Unit
        └── CafeFeeCalculatorTest.php
```

---

## セットアップ

### コンテナ起動

```bash
docker compose up -d
```

### Laravelコンテナへ入る

```bash
docker compose exec php bash
```

### パッケージインストール

```bash
composer install
```

---

## テスト実行

```bash
php artisan test
```

または

```bash
php artisan test --filter=CafeFeeCalculatorTest
```

---

## 実装内容

料金計算では以下の仕様を実装しています。

- コース料金
- 10分単位の延長料金
- 1分以上の超過は切り上げ
- 深夜延長料金（15%割増）
- 消費税（10%）
- Unitテストによる境界値の確認
