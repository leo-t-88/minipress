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

  String _searchQuery = "";
  String get searchQuery => _searchQuery;

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

  void setSearchQuery(String query) {
    _searchQuery = query.toLowerCase().trim();
    notifyListeners();
  }

  /// Liste triée uniquement par date
List<Article> get articles {
    List<Article> filtered = _articles;
    
    if (_searchQuery.isNotEmpty) {
      filtered = _articles.where((article) {
        final matchTitle = article.title.toLowerCase().contains(_searchQuery);
        
        final matchSummary = article.summary != null && 
                             article.summary!.toLowerCase().contains(_searchQuery);
        
        return matchTitle || matchSummary;
      }).toList();
    }

    final sorted = [...filtered];
    sorted.sort((a, b) => a.createdAt.compareTo(b.createdAt));

    return _sortAscending ? sorted : sorted.reversed.toList();
  }
}
