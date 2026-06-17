import 'package:dio/dio.dart';
import '../models/article.dart';
import '../models/category.dart';

class ArticleService {
  final Dio _dio = Dio();
  final String baseUrl = "http://docketu.iutnc.univ-lorraine.fr:16797";

  Future<List<Article>> fetchArticles() async {
    final response = await _dio.get("$baseUrl/api/articles");
    final List rawList = response.data["articles"];

    final Future<List<Article>> futureArticles = Future.wait(rawList.map((json) async {
      final a = json["article"];
      final String detailHref = json["links"]["self"]["href"];

      String? resumeComplet;

      try {
        final detailResponse = await _dio.get("$baseUrl$detailHref");
        resumeComplet = detailResponse.data["article"]["resume"];
      } catch (e) {
        print("Impossible de charger le résumé pour l'article ${a["titre"]}: $e");
      }
      
      return Article(
        id: detailHref.hashCode,
        title: a["titre"] ?? "",
        author: a["auteur_id"].toString(),
        createdAt: DateTime.parse(a["date_creation"]),
        summary: resumeComplet,
      );
    }).toList());

    return await futureArticles;
  }

  Future<List<Category>> fetchCategories() async {
    final response = await _dio.get("$baseUrl/api/categories");
    final List rawList = response.data["categories"];

    return rawList.map((json) => Category.fromJson(json)).toList();
  }

  Future<List<Article>> fetchArticlesByCategory(int categoryId) async {
    final response = await _dio.get("$baseUrl/api/categories/$categoryId/articles");
    final List rawList = response.data["articles"];

    final Future<List<Article>> futureArticles = Future.wait(rawList.map((json) async {
      final a = json["article"];
      final String detailHref = json["links"]["self"]["href"];

      String? resumeComplet;
      try {
        final detailResponse = await _dio.get("$baseUrl$detailHref");
        resumeComplet = detailResponse.data["article"]["resume"];
      } catch (_) {}

      return Article(
        id: detailHref.hashCode,
        title: a["titre"] ?? "",
        author: a["auteur_id"].toString(),
        createdAt: DateTime.parse(a["date_creation"]),
        summary: resumeComplet,
      );
    }).toList());

    return await futureArticles;
  }
}