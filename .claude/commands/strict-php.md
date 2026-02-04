# Strict PHP Type Enforcement

## 役割
既存のPHPファイルの型定義を厳格化し、Laravel 12+ の最新の型プラクティスを適用します。

## 指示事項
1. **ファイルの先頭**: 必ず `declare(strict_types=1);` を追加してください。
2. **引数と戻り値**: 全ての関数・メソッドに適切な型ヒント（引数）と戻り値の型（Return Type）を追加してください。
3. **プロパティ**: クラスプロパティには必ず型を指定してください（例: `private string $name;`）。
4. **Laravel固有の型**:
   - コレクションには `Collection<int, User>` のようなジェネリクス形式のPHPDocを追加してください。
   - `Request` や `Response` は適切なクラス（`Illuminate\Http\Request` 等）で型指定してください。
5. **null許容**: nullableな値には `string|null` を適切に使用してください。
6. **不必要なキャストの削除**: 型定義によって不要になった手動のキャストをクリーンアップしてください。