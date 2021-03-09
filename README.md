# amazon-product-advertising

アマゾン商品情報APIを使って記事ごとに特有の商品を出すプラグインです。


## Install

$ make

.artifact/ctms-feed.zip をWordpressへ追加。


## ローカル動作確認

以下のコマンドを実行。

```
$ docker-compose up -d
```

http://localhost:8080/ へアクセスするとWordpressの画面が出ます。


## メンテナ向け情報

更新時は以下の箇所も忘れず修正してください。

 * CHANGELOG.mdに追加
 * ctms-feed.phpのVersion
