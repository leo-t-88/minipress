class Article {
  final int id;
  final String title;
  final String author;
  final DateTime createdAt;

  Article({
    required this.id,
    required this.title,
    required this.author,
    required this.createdAt,
  });

  factory Article.fromJson(Map<String, dynamic> json) {
    return Article(
      id: json["id"],
      title: json["titre"],
      author: json["auteur"],
      createdAt: DateTime.parse(json["date_creation"]),
    );
  }
}
