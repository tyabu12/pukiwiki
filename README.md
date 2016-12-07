# PukiWiki

PukiWiki 1.5.1 UTF-8版の自分用の改造版です。
備忘録を兼ねて。

## 改造点

- XMLサイトマップの生成
- スマートフォン表示の対応
- 動画の埋め込みに対応

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

### 動画の埋め込みに対応

[ネットvideo動画表示プラグイン](http://heeha.ws/index.php?%A5%CD%A5%C3%A5%C8video%C6%B0%B2%E8%C9%BD%BC%A8%A5%D7%A5%E9%A5%B0%A5%A4%A5%F3)を取り込みました。

現状スマートフォンは動画の大きさが変わらないのでおかしくなります。
