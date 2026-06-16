import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
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
        preferredSize: const Size.fromHeight(40),
          child: InkWell(
            borderRadius: BorderRadius.circular(20),
            onTap: () {
              context.read<ArticleProvider>().toggleSortOrder();
            },
            child: Padding(
              padding: const EdgeInsets.only(bottom: 8),
              child: Chip(
                labelPadding: const EdgeInsets.symmetric(horizontal: 10),
                avatar: Icon(
                  provider.sortAscending ? Icons.arrow_upward : Icons.arrow_downward,
                  size: 18,
                ),
                label: Text(provider.sortAscending ? "Ancien" : "Nouveau"),
              ),
            ),
          ),
        ),
      ),
      body: Column(
        children: [
          Expanded(
            child : provider.isLoading ? const Center(child: CircularProgressIndicator()) : ListView.builder(
              itemCount: provider.articles.length,
              itemBuilder: (context, index) {
                final article = provider.articles[index];
                return ListTile(
                  title: Text(article.title),
                  subtitle: Text(
                    "Créé le : ${article.createdAt}\n"
                    "Auteur : ${article.author}",
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
