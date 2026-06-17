import 'package:flutter/foundation.dart' hide Category;
import '../models/article.dart';
import '../models/category.dart';
import '../services/article_service.dart';

class ArticleProvider extends ChangeNotifier {
  final ArticleService _service = ArticleService();

  final List<Article> _articles = [];
  final List<Category> _categories = [];

  bool _isLoading = true;
  bool get isLoading => _isLoading;

  bool _sortAscending = false;
  bool get sortAscending => _sortAscending;

  List<Category> get categories => _categories;

  ArticleProvider() {
    loadArticles();
  }

  Future<void> loadArticles() async {
    _isLoading = true;
    notifyListeners();

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

  List<Article> get articles {
    final sorted = [..._articles];

    sorted.sort((a, b) => a.createdAt.compareTo(b.createdAt));

    return _sortAscending ? sorted : sorted.reversed.toList();
  }
}