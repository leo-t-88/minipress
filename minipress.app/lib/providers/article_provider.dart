import 'package:flutter/foundation.dart';
import '../models/article.dart';
import '../services/article_service.dart';

class ArticleProvider extends ChangeNotifier {
  final ArticleService _service = ArticleService();

  final List<Article> _articles = [];
  bool _isLoading = true;

  bool get isLoading => _isLoading;

  bool _sortAscending = false;
  bool get sortAscending => _sortAscending;

  ArticleProvider() {
    loadArticles();
  }

  Future<void> loadArticles() async {
    try {
      final fetched = await _service.fetchArticles();
      _articles.addAll(fetched);
    } catch (e) {
      debugPrint("Erreur API: $e");
    }

    _isLoading = false;
    notifyListeners();
  }

  /// Inverse l'ordre (ASC <-> DESC)
  void toggleSortOrder() {
    _sortAscending = !_sortAscending;
    notifyListeners();
  }

  /// Liste triée uniquement par date
  List<Article> get articles {
    final sorted = [..._articles];

    sorted.sort((a, b) => a.createdAt.compareTo(b.createdAt));

    return _sortAscending ? sorted : sorted.reversed.toList();
  }
}
