import 'package:dio/dio.dart';
import '../models/article.dart';
import '../models/category.dart';

class ArticleService {
  final Dio _dio = Dio();
  final String baseUrl = "http://docketu.iutnc.univ-lorraine.fr:16797";

  Future<List<Article>> fetchArticles() async {
    final response = await _dio.get("$baseUrl/api/articles");

    final List rawList = response.data["articles"];

    return rawList.map((json) {
      final a = json["article"];
      return Article(
        id: json["links"]["self"]["href"].hashCode,
        title: a["titre"],
        author: a["auteur_id"].toString(),
        createdAt: DateTime.parse(a["date_creation"]),
      );
    }).toList();
  }

  Future<List<Category>> fetchCategories() async {
    final response = await _dio.get("$baseUrl/api/categories");
    final List rawList = response.data["categories"];

    return rawList.map((json) => Category.fromJson(json)).toList();
  }

  Future<List<Article>> fetchArticlesByCategory(int categoryId) async {
    final response = await _dio.get("$baseUrl/api/categories/$categoryId/articles");
    final List rawList = response.data["articles"];

    return rawList.map((json) {
      final a = json["article"];
      return Article(
        id: json["links"]["self"]["href"].hashCode,
        title: a["titre"],
        author: a["auteur_id"].toString(),
        createdAt: DateTime.parse(a["date_creation"]),
      );
    }).toList();
  }
}
