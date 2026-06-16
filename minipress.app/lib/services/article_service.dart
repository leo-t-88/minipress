import 'package:dio/dio.dart';
import '../models/article.dart';

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
}
