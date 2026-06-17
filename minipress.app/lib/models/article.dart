class Article {
  final int? id;
  final String title;
  final String author;
  final DateTime createdAt;
  final DateTime? publishedAt;
  final String? resume;
  final String? content;
  final String? apiUrl;

  Article({
    this.id,
    required this.title,
    required this.author,
    required this.createdAt,
    this.publishedAt,
    this.resume,
    this.content,
    this.apiUrl,
  });
}
