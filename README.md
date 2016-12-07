# PukiWiki

PukiWiki 1.5.1 UTF-8版の自分用の改造版です。
備忘録を兼ねて。

## 改造点

- XMLサイトマップの生成
- スマートフォン表示の対応

## 使い方

### XMLサイトマップの生成

[sitemapプラグイン](http://su-u.jp/juju/%A5%B5%A1%BC%A5%D0/PukiWiki/sitemap.html)を取り込みました。

`http://foo/sitemap.xml` を `http://foo/index.php?cmd=sitemap` にリダイレクトするようにしてあげて

`http://foo/robots.txt` に

```
User-Agent:*
Disallow:

Sitemap:http://foo/sitemap.xml
```

みたいな感じで書いてあげればOK。

### スマートフォン表示の対応

[スマホ対応版のスキン](http://180xz.com/wiki/index.php?Wiki/PukiWiki/Skin/black-smartphone（スマホ対応版）)を取り込みました。
