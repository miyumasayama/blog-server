# blog-server
こちらを参考に作成
- https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4

## コンテナ作成
- docker compose up -d

## コンテナ削除
- docker compose down

## laravel内コンテナにはいる
- docker compose exec app bash

## db内コンテナに入る
- docker compose exec app bash

## 認証
- sanctumのToken認証を使用
