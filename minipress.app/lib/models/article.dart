class Article {
  final int id;
  final String title;
  final String author;
  final DateTime createdAt;
  final String? summary;

  Article({
    required this.id,
    required this.title,
    required this.author,
    required this.createdAt,
    this.summary,
  });

  factory Article.fromJson(Map<String, dynamic> json) {
    return Article(
      id: json["id"],
      title: json["titre"],
      author: json["auteur"],
      createdAt: DateTime.parse(json["date_creation"]),
      summary: json["resume"],
    );
  }
}
