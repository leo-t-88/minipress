import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../widget/article_tile.dart';
import '../providers/article_provider.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<ArticleProvider>();

    return Scaffold(
      appBar: AppBar(
        title: const Text("MiniPress"),
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(100),
          child: Column(
            children: [
              ActionChip(
                label: Text(provider.sortAscending ? "Ancien" : "Nouveau"),
                avatar: Icon(
                  provider.sortAscending
                      ? Icons.arrow_upward
                      : Icons.arrow_downward,
                  size: 16,
                ),
                onPressed: () {
                  context.read<ArticleProvider>().toggleSortOrder();
                },
              ),
              const SizedBox(height: 8),
              SizedBox(
                height: 50,
                child: provider.isLoading
                    ? const SizedBox()
                    : ListView.builder(
                        scrollDirection: Axis.horizontal,
                        itemCount: provider.categories.length,
                        itemBuilder: (context, index) {
                          final category = provider.categories[index];
                          return Padding(
                            padding: const EdgeInsets.symmetric(horizontal: 8),
                            child: ActionChip(
                              label: Text(category.nom),
                              onPressed: () {
                                context
                                    .read<ArticleProvider>()
                                    .loadArticlesByCategory(category.id);
                              },
                            ),
                          );
                        },
                      ),
              ),
            ],
          ),
        ),
      ),
      body: provider.isLoading
          ? const Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: provider.articles.length,
              itemBuilder: (context, index) {
                final article = provider.articles[index];
                return ArticleTile(article: article);
              },
            ),
    );
  }
}