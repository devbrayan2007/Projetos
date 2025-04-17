package com.example.fablab;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.layout.*;
import javafx.scene.text.Font;
import javafx.stage.Stage;

public class Dashboard {

    private final ObservableList<Produto> listaProdutos = FXCollections.observableArrayList();

    public void mostrar() {
        Stage dashStage = new Stage();
        dashStage.setTitle("Dashboard - FabLab");

        // Cabeçalho
        Label titulo = new Label("Painel Principal");
        titulo.setFont(new Font("Arial Bold", 24));
        titulo.setPadding(new Insets(20));
        titulo.setStyle("-fx-background-color: #005aa7; -fx-text-fill: white;");
        HBox header = new HBox(titulo);
        header.setAlignment(Pos.CENTER);
        header.setStyle("-fx-background-color: #005aa7");

        // Menu lateral
        VBox menu = new VBox(20);
        menu.setPadding(new Insets(20));
        menu.setStyle("-fx-background-color: #f0f0f0;");
        menu.setPrefWidth(150);

        Button btnProjetos = new Button("Projetos");
        Button btnUsuarios = new Button("Usuários");
        Button btnProdutos = new Button("Produtos");
        Button btnSair = new Button("Sair");

        for (Button btn : new Button[]{btnProjetos, btnUsuarios, btnProdutos, btnSair}) {
            btn.setMaxWidth(Double.MAX_VALUE);
        }

        // Conteúdo principal
        StackPane content = new StackPane();
        Label conteudoInicial = new Label("Bem-vindo ao FabLab!");
        conteudoInicial.setFont(new Font("Arial", 18));
        content.getChildren().add(conteudoInicial);
        content.setAlignment(Pos.CENTER);

        // Ações dos botões
        btnProjetos.setOnAction(e -> {
            content.getChildren().clear();
            Label projetosLabel = new Label("Lista de Projetos:\n- Impressora 3D\n- Cortadora Laser\n- CNC Router");
            projetosLabel.setFont(new Font("Arial", 16));
            projetosLabel.setWrapText(true);
            content.getChildren().add(projetosLabel);
        });

        btnUsuarios.setOnAction(e -> {
            content.getChildren().clear();
            Label usuariosLabel = new Label("Usuários cadastrados:\n- João Silva\n- Maria Oliveira\n- Pedro Santos");
            usuariosLabel.setFont(new Font("Arial", 16));
            usuariosLabel.setWrapText(true);
            content.getChildren().add(usuariosLabel);
        });

        btnProdutos.setOnAction(e -> mostrarTelaProdutos(content));

        btnSair.setOnAction(e -> dashStage.close());

        menu.getChildren().addAll(btnProjetos, btnUsuarios, btnProdutos, btnSair);

        // Layout principal
        BorderPane root = new BorderPane();
        root.setTop(header);
        root.setLeft(menu);
        root.setCenter(content);

        Scene cena = new Scene(root, 800, 600);
        dashStage.setScene(cena);
        dashStage.show();
    }

    private void mostrarTelaProdutos(StackPane contentPane) {
        contentPane.getChildren().clear();

        VBox layout = new VBox(10);
        layout.setPadding(new Insets(20));

        // Campo de busca
        TextField campoBusca = new TextField();
        campoBusca.setPromptText("Buscar por nome...");

        // Tabela
        TableView<Produto> tabela = new TableView<>(listaProdutos);
        TableColumn<Produto, String> colNome = new TableColumn<>("Nome");
        colNome.setCellValueFactory(new PropertyValueFactory<>("nome"));
        colNome.setPrefWidth(200);

        TableColumn<Produto, Integer> colUnidades = new TableColumn<>("Unidades");
        colUnidades.setCellValueFactory(new PropertyValueFactory<>("unidades"));
        colUnidades.setPrefWidth(100);

        tabela.getColumns().addAll(colNome, colUnidades);

        // Campos de cadastro
        TextField nomeInput = new TextField();
        nomeInput.setPromptText("Nome do produto");

        TextField unidadeInput = new TextField();
        unidadeInput.setPromptText("Unidades");

        Button btnAdicionar = new Button("Adicionar");
        Button btnEditar = new Button("Editar");
        Button btnRemover = new Button("Remover");

        HBox form = new HBox(10, nomeInput, unidadeInput, btnAdicionar, btnEditar, btnRemover);
        form.setAlignment(Pos.CENTER);

        // Filtro de busca
        campoBusca.textProperty().addListener((obs, oldVal, newVal) -> {
            ObservableList<Produto> filtrado = FXCollections.observableArrayList();
            for (Produto p : listaProdutos) {
                if (p.getNome().toLowerCase().contains(newVal.toLowerCase())) {
                    filtrado.add(p);
                }
            }
            tabela.setItems(filtrado);
        });

        // Adicionar produto
        btnAdicionar.setOnAction(e -> {
            String nome = nomeInput.getText();
            int unidades;

            try {
                unidades = Integer.parseInt(unidadeInput.getText());
            } catch (NumberFormatException ex) {
                mostrarAlerta("Erro", "Unidades deve ser um número inteiro.");
                return;
            }

            if (nome.isEmpty()) {
                mostrarAlerta("Erro", "O nome não pode estar vazio.");
                return;
            }

            Produto novo = new Produto(nome, unidades);
            listaProdutos.add(novo);
            nomeInput.clear();
            unidadeInput.clear();

            if (unidades < 300) {
                mostrarAlerta("Atenção", "O produto '" + nome + "' está com estoque baixo!");
            }
        });

        // Editar produto
        btnEditar.setOnAction(e -> {
            Produto selecionado = tabela.getSelectionModel().getSelectedItem();
            if (selecionado != null) {
                String novoNome = nomeInput.getText();
                int novasUnidades;
                try {
                    novasUnidades = Integer.parseInt(unidadeInput.getText());
                } catch (NumberFormatException ex) {
                    mostrarAlerta("Erro", "Unidades deve ser um número inteiro.");
                    return;
                }

                selecionado.setNome(novoNome);
                selecionado.setUnidades(novasUnidades);
                tabela.refresh();

                if (novasUnidades < 300) {
                    mostrarAlerta("Atenção", "O produto '" + novoNome + "' está com estoque baixo!");
                }
            }
        });

        // Remover produto
        btnRemover.setOnAction(e -> {
            Produto selecionado = tabela.getSelectionModel().getSelectedItem();
            if (selecionado != null) {
                listaProdutos.remove(selecionado);
            }
        });

        layout.getChildren().addAll(campoBusca, tabela, form);
        contentPane.getChildren().add(layout);
    }

    private void mostrarAlerta(String titulo, String mensagem) {
        Alert alert = new Alert(Alert.AlertType.WARNING);
        alert.setTitle(titulo);
        alert.setHeaderText(null);
        alert.setContentText(mensagem);
        alert.showAndWait();
    }

    // Classe Produto
    public static class Produto {
        private String nome;
        private int unidades;

        public Produto(String nome, int unidades) {
            this.nome = nome;
            this.unidades = unidades;
        }

        public String getNome() {
            return nome;
        }

        public void setNome(String nome) {
            this.nome = nome;
        }

        public int getUnidades() {
            return unidades;
        }

        public void setUnidades(int unidades) {
            this.unidades = unidades;
        }
    }
}
