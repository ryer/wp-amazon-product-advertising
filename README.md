# amazon-product-advertising

アマゾンアソシエイトのPA-APIを利用したシンプルなプラグインです。

## 概要

原則としてショートコードで動作します。

投稿画面に追加されている「Amazon search params」には、

ショートコードのパラメータの記述をそのまま利用できます。

投稿とショートコードのパラメータを合体してPA-APIへアクセスします。

## ショートコードの例

```
[amazon_pa]
[amazon_pa スマホ ハイエンド display_limit=10 trim_title_width=20]
[amazon_pa スマホ ハイエンド search_index=Electronics]
[amazon_pa keywords="ハイエンド galaxy|pixel" browse_node_id=128188011]
```

## 利用可能なパラメータ

* keywords
* search_index
* browse_node_id
* display_limit
* trim_title_width

## パラメータフィルタ

パラメータを動的に変更したいときに使ってください。

```
add_filter('amazon_pa_params', function ($params) {
    if (isset($params['keywords'])) {
        return $params;
    }

    $current_slug = ($c = get_the_category()) ? $c[0]->slug : '';
    if (is_category('smartphone') or $current_slug === 'smartphone') {
        $params['keywords'] = 'スマホ ハイエンド';
        $params['search_index'] = 'Electronics';
    }

    return $params;
});
```

## キャッシュによる制限

APIキャッシュのためにmetaテーブルを利用しているため、

postmetaまたはtermmetaが使用可能な場合にのみ動作します。

例）投稿ページ・固定ページ・カテゴリ記事一覧・タグ記事一覧

キャッシュの秒数は可能な限り長くすることをおすすめします。

## License

MIT

## Author

ryer (@ryer)
