import 'package:flutter/foundation.dart' hide Category;
import '../models/article.dart';
import '../models/category.dart';
import '../services/api_service.dart';

class ArticleProvider extends ChangeNotifier {
  final ApiService _service = ApiService();

  final List<Article> _articles = [];
  final List<Category> _categories = [];

  bool _isLoading = true;
  bool get isLoading => _isLoading;

  bool _sortAscending = false;
  bool get sortAscending => _sortAscending;

  List<Category> get categories => _categories;

  String _searchQuery = "";
  String get searchQuery => _searchQuery;

  ArticleProvider() {
    loadArticles();
  }

  Future<void> loadArticles() async {
    try {
      final fetched = await _service.fetchArticles();
      final fetchedCategories = await _service.fetchCategories();

      _articles.clear();
      _articles.addAll(fetched);

      _categories.clear();
      _categories.addAll(fetchedCategories);
    } catch (e) {
      debugPrint("Erreur API: $e");
    }

    _isLoading = false;
    notifyListeners();
  }

  Future<void> loadArticlesByCategory(int categoryId) async {
    _isLoading = true;
    notifyListeners();

    try {
      final fetched = await _service.fetchArticlesByCategory(categoryId);
      _articles.clear();
      _articles.addAll(fetched);
    } catch (e) {
      debugPrint("Erreur API catégorie: $e");
    }

    _isLoading = false;
    notifyListeners();
  }

  void toggleSortOrder() {
    _sortAscending = !_sortAscending;
    notifyListeners();
  }

  void setSearchQuery(String query) {
    _searchQuery = query.toLowerCase().trim();
    notifyListeners();
  }

  List<Article> get articles {
    List<Article> filtered = _articles;

    if (_searchQuery.isNotEmpty) {
      filtered = _articles.where((article) {
        final matchTitle = article.title.toLowerCase().contains(_searchQuery);
        final matchResume =
            article.resume != null &&
            article.resume!.toLowerCase().contains(_searchQuery);

        return matchTitle || matchResume;
      }).toList();
    }

    final sorted = [...filtered];
    sorted.sort((a, b) => a.createdAt.compareTo(b.createdAt));

    return _sortAscending ? sorted : sorted.reversed.toList();
  }

  List<Article> getArticlesByAuthor(String author) {
    return articles.where((article) => article.author == author).toList();
  }
}
