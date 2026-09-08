-- DLStore: esquema limpo e catálogo de demonstração.
SET NAMES utf8mb4;


CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `situacao` enum('Ativo','Bloqueado') DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categorias` (`id_categoria`, `nome`, `situacao`) VALUES
(9, 'Redes', 'Ativo'),
(10, 'Consoles', 'Ativo'),
(11, 'Cadeiras Gamer', 'Ativo'),
(12, 'Notebook Gamer', 'Ativo'),
(17, 'Pc\'s Gamers', 'Ativo'),
(18, 'Perfiericos ', 'Ativo'),
(20, 'Componentes ', 'Ativo'),
(22, 'Monitores ', 'Ativo');

ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

CREATE TABLE `clientes` (
  `cpf` varchar(16) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `situacao` enum('Ativo','Bloqueado') DEFAULT 'Ativo',
  `sexo` enum('M','F') DEFAULT 'M',
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(250) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `cep` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cpf`);

CREATE TABLE `item_vendas` (
  `id_item` int(11) NOT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `item_vendas`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `FK_id_venda` (`id_venda`),
  ADD KEY `FK_id_produtos` (`id_produto`);

ALTER TABLE `item_vendas`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nome_produto` varchar(250) NOT NULL,
  `detalhes` text DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `situacao` enum('Ativo','Bloqueado') DEFAULT 'Ativo',
  `destaque` enum('S','N') DEFAULT 'N',
  `visitas` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `foto_principal` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produtos` (`id_produto`, `id_categoria`, `nome_produto`, `detalhes`, `valor`, `quantidade`, `situacao`, `destaque`, `visitas`, `data_cadastro`, `foto_principal`) VALUES
(1, 22, 'MONITOR GAMER LG ', 'MONITOR GAMER LG ULTRAGEAR', 1000.00, 4, 'Ativo', 'S', NULL, '2023-10-24 01:53:50', 'm1.png'),
(2, 22, 'MONITOR GAMER ASUS\r\n', 'MONITOR GAMER ASUS TUF VG277Q1A', 1300.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 01:59:09', 'm2.png'),
(3, 22, 'MONITOR GAMER ASUS ROG', 'MONITOR GAMER ASUS ROG SWIFT PG42UQ', 10400.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:01:44', 'm3.png'),
(4, 22, 'MONITOR GAMER ACER NITRO', 'MONITOR GAMER ACER NITRO EDO', 1100.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:04:15', 'm4.png'),
(5, 22, 'MONITOR ACER KA2', 'MONITOR ACER KA2, 23.8 POL, VA, FHD, 1MS', 700.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:06:23', 'm5.png'),
(6, 22, 'MONITOR GAMER PICHAU ', 'MONITOR GAMER PICHAU CEPHEUS VPRO27', 2100.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:08:15', 'm6.png'),
(7, 12, 'NOTEBOOK GIGABYTE \r\n', 'NOTEBOOK GAMER GIGABYTE AORUS 15 9MF', 8900.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:16:42', 'n1.png'),
(9, 12, 'NOTEBOOK GAMER', 'NOTEBOOK GAMER GIGABYTE G5 KF,', 8800.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:19:44', 'n22.png'),
(11, 12, 'NOTEBOOK GAMER AVELL', 'NOTEBOOK GAMER AVELL A70 HYB, INTEL I7', 8900.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:22:25', 'n3.png'),
(13, 12, 'NOTEBOOK ACER ASPIRE', 'NOTEBOOK ACER ASPIRE 3, 15,6 POL., I5-1135G7, 8GB DDR4, 256GB, A315-58-573P', 3300.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 02:26:08', 'n4.png.png'),
(30, NULL, 'Ssd Sandisk 480GB', 'SSD SanDisk, Ssd com capacidade de 480 gb de memoria, que tras uma otima velocidade para o seu computador ', 300.00, 1, 'Ativo', 'S', NULL, '0000-00-00 00:00:00', 'ssd.png'),
(32, 17, 'PC GAMER RYZEN 7 ', 'PC GAMER RYZEN 7 5700G, 16GB DDR4 3200MHZ, SSD M.2 NVME 250GB, VEGA 7', 2600.00, 3, 'Ativo', 'S', NULL, '2023-10-18 02:09:50', '1.png.png'),
(2301, 17, 'Computador Gamer ', 'RGB Intel Core i5 8GB HD 500GB Kit Gamer com Headset Monitor 20\" Windows 10 3green Premium', 1599.00, 3, 'Ativo', 'S', NULL, '2023-10-18 02:20:59', 'pc2.png.png'),
(2302, 17, 'PC ITX Gamer FPS', 'PC ITX Gamer FPS Headshot, Core I5 13400F, NVídia GeForce RTX 3060 12GB, 16GB Ram, SSD M.2 500GB', 3999.00, 2, 'Ativo', 'S', NULL, '2023-10-18 02:22:21', 'pc3.png.png'),
(2303, 17, 'PC Gamer Completo ', 'PC Gamer Completo 3green Play Intel Core i5 16GB RAM Placa de vídeo Geforce 4GB SSD 256GB Monitor 20\" 75Hz Fonte 500W 3GP-031', 1939.00, 3, 'Ativo', 'S', NULL, '2023-10-18 02:23:16', 'pc4.png.png'),
(2305, 17, 'Cpu Gamer Gab.', 'Cpu Gamer Gab. Mid Tower Ryzen 5 5500 Mem 16gb Ddr4 Nvme 500gb RTX 3060 12GB', 5300.00, NULL, 'Ativo', 'S', NULL, '2023-10-18 02:28:36', 'pc5.png.png'),
(2307, 17, 'PC Gamer AMD Ryzen 7 5700G  ', 'PC Gamer AMD Ryzen 7 5700G   8 Núcleos 4.60Ghz, Gráficos Radeon VEGA 8, 16GB DDR4, SSD 512GB, Fonte 500W, 3green Force', 2580.00, 2, 'Ativo', 'S', NULL, '2023-10-18 02:35:10', 'pc6.png.png'),
(2308, 17, 'Pc Gamer Completo ', 'Pc Gamer Completo 3green fps Intel Core i5 \r\n', 2000.00, 4, 'Ativo', 'S', NULL, '2023-10-18 02:38:20', 'pc7.png'),
(2309, 17, 'Computador Pichau ', 'Computador Pichau Gamer Balam, AMD Ryzen 5 4600G, 16GB DDR4, SSD 240GB', 1670.00, 2, 'Ativo', 'S', NULL, '2023-10-18 02:40:58', 'pc8.png'),
(2310, 18, 'HyperX Microfone Gamer ', 'HyperX Microfone Gamer QuadCast', 700.00, NULL, 'Ativo', 'S', NULL, '2023-10-18 02:41:46', 'pe1.png'),
(2311, 18, 'Teclado para jogos Redragon ', 'Teclado para jogos Redragon K617 Fizz 60% RGB com fio', 355.00, NULL, 'Ativo', 'S', NULL, '2023-10-18 02:44:25', 'pe2.png'),
(2312, 18, 'HyperX Teclado Gamer', 'HyperX Teclado Gamer HyperX Alloy Core RGB, ABNT2', 179.00, NULL, 'Ativo', 'S', NULL, '2023-10-18 02:45:39', 'pe3.png'),
(2313, 18, 'Teclado Multilaser Slim', 'Teclado Multilaser Slim Preto Laser Usb', 24.00, 15, 'Ativo', 'N', NULL, '2023-10-18 02:48:35', 'pe4.png'),
(2314, 18, 'Redragon MOUSE GAMER', 'Redragon MOUSE GAMER GRIFFIN BRANCO COM LED ', 105.00, 7, 'Ativo', 'S', NULL, '2023-10-18 02:49:57', 'pe5.png.png'),
(2315, 18, 'HP - Mouse Gamer ', 'HP - Mouse Gamer USB M160 Preto ', 51.00, 5, 'Ativo', 'S', NULL, '2023-10-18 02:51:04', 'pe6.png.png'),
(2316, 18, 'Headphone Fone de Ouvido ', 'Headphone Fone de Ouvido Havit HV', 198.00, 10, 'Ativo', 'S', NULL, '2023-10-18 02:52:48', 'pe7.png'),
(2317, 18, 'Headset Gamer ', 'Headset Gamer Preto/Vermelho ', 35.00, 9, 'Ativo', 'S', NULL, '2023-10-18 02:53:41', 'pe8.png'),
(2318, 20, 'PLACA-MÃE GIGABYTE ', 'PLACA-MÃE GIGABYTE B450 GAMIN', 599.00, 9, 'Ativo', 'S', NULL, '2023-10-18 02:56:23', 'c1.png'),
(2319, 20, 'Processador AMD Ryzen 5', 'Processador AMD Ryzen 5 5600G', 815.00, 12, 'Ativo', 'S', NULL, '2023-10-18 02:57:23', 'c2.png'),
(2320, 20, 'Kit Upgrade Líder', 'Kit Upgrade Líder, AMD Ryzen 5 5600G', 1699.00, 7, 'Ativo', 'S', NULL, '2023-10-18 03:00:50', 'p3.png'),
(2321, 20, 'Fonte de Alimentação ', 'Fonte de Alimentação 500W', 210.00, 6, 'Ativo', 'S', NULL, '2023-10-18 03:01:59', 'c4.png'),
(2322, 20, 'Cooler NZXT Kraken', 'Cooler NZXT Kraken M22 120mm ', 851.00, 5, 'Ativo', 'S', NULL, '2023-10-18 03:04:09', 'c5.png'),
(2323, 20, 'Kit 3 Fans Cooler ', 'Kit 3 Fans Cooler Led Rgb 120mm', 85.00, 8, 'Ativo', 'S', NULL, '2023-10-18 03:05:26', 'c6.png'),
(2324, 20, 'Memória de 16GB', 'Memória de 16GB ', 305.00, 11, 'Ativo', 'S', NULL, '2023-10-18 03:06:56', 'c7.png'),
(2325, 20, 'Placa de Video Galax GTX ', 'Placa de Video Galax GTX 1650 EX', 969.00, 13, 'Ativo', 'S', NULL, '2023-10-18 03:09:14', 'c8.png'),
(2326, 17, 'COMPUTADOR MANCER GAMER', 'COMPUTADOR MANCER GAMER, INTEL I5-13400F, RADEON RX 7600 8GB, 16GB DDR4, SSD 480GB', NULL, NULL, 'Ativo', 'S', NULL, '2023-10-24 01:42:59', 'pc9.png'),
(2328, 12, 'NOTEBOOK GIGABYTE', 'NOTEBOOK GAMER GIGABYTE G5 GD', 8900.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:36:59', 'n5.png'),
(2329, 11, 'CADEIRA GAMER THUNDERX3', 'CADEIRA GAMER THUNDERX3 TGC12 PRETO COM VERDE', 1000.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:41:06', 'ca1.png'),
(2330, 11, 'CADEIRA GAMER THUNDERX3 ', 'CADEIRA GAMER THUNDERX3 TGC12 PRETO COM AZUL, TGC12-PT/AZ', 1000.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:42:47', 'ca2.png'),
(2331, 11, 'CADEIRA GAMER THUNDERX3', 'CADEIRA GAMER THUNDERX3 TGC12 PRETO, TGC12-PT/PT', 1100.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:43:51', 'ca3.png'),
(2332, 11, 'CADEIRA GAMER COUGAR', 'CADEIRA GAMER COUGAR ARMOR ELITE EVA, PRETO E ROSA, 3MELIPNB.0001', 1059.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:45:40', 'ca4.png'),
(2333, 11, 'CADEIRA GAMER COUGAR', 'CADEIRA GAMER COUGAR ARMOR ELITE BLACK, 3MELIBLB.0001', 1120.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:48:16', 'ca5.png'),
(2334, 10, 'CONSOLE MICROSOFT XBOX ', 'CONSOLE MICROSOFT XBOX SERIES S, 512GB, 1 CONTROLE, BRANCO, RRS-00006', 2100.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:53:16', 'v1.png'),
(2335, 10, 'CONSOLE MICROSOFT XBOX ', 'CONSOLE MICROSOFT XBOX SERIES X FORZA HORIZON 5 PREMIUM EDITION, 1TB, 1 CONTROLE, PRETO, RRT-00057', 4000.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:54:55', 'v2.png'),
(2336, 10, 'SONY PLAYSTATION 5', 'CONSOLE SONY PLAYSTATION 5, 1 CONTROLE, BRANCO, PS5, CFI-1214A', 4000.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:57:22', 'v3.png'),
(2337, 10, 'CONSOLE XBOX', 'CONSOLE MICROSOFT XBOX SERIES X, 1TB, 1 CONTROLE, PRETO, RRT-00006', 3900.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 22:59:13', 'v4.png'),
(2338, 10, 'NINTENDO SWITCH', 'CONSOLE NINTENDO SWITCH, 32GB, COM JOGO MARIO KART DELUXE 8, HADSKABL1BRA', 2150.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:02:31', 'v5.png'),
(2339, 9, 'PLACA DE REDE PCI-EXPRESS', 'PLACA DE REDE PCI-EXPRESS NORMAL E LOW PROFILE 10/100/1000, JC-PCI-EX', 36.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:13:00', 'r1.png'),
(2340, 9, 'PLACA DE REDE TP-LINK', 'PLACA DE REDE TP-LINK GIGABIT PCI EXPRESS 10/100/1000MBPS, TG-3468', 105.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:14:32', 'r2.png'),
(2341, 9, 'REPETIDOR WI-FI TP-LINK', 'REPETIDOR WI-FI TP-LINK AC750 433MBPS, RE200', 169.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:15:52', 'r3.png'),
(2342, 9, 'ROTEADOR TP-LINK ', 'ROTEADOR TP-LINK LOAD BALANCE BROADBAND 10/100MBPS, TL-R470T+', 269.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:17:22', 'r4.png'),
(2343, 9, 'ADAPTADOR BLUETOOTH MD9', 'ADAPTADOR BLUETOOTH MD9 5.0, USB 2.0/4.0, PRETO, 9208', 30.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:18:43', 'r5.png'),
(2344, 9, 'ACCESS POINT DE PAREDE ', 'ACCESS POINT DE PAREDE GIGABIT TP-LINK, AC1200 WIRELESS MU-MIMO, DUAL BAND, BRANCO, EAP235-WALL', 599.00, NULL, 'Ativo', 'S', NULL, '2023-10-24 23:20:13', 'r6.png');

ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `FK_id_categoria` (`id_categoria`);

ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2345;

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `data_venda` datetime DEFAULT NULL,
  `cpf` varchar(16) NOT NULL,
  `forma_pagto` enum('Boleto','Cartão') DEFAULT NULL,
  `parcelas` int(11) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `valor_frete` decimal(5,2) DEFAULT NULL,
  `prazo_entrega` varchar(25) DEFAULT NULL,
  `endereco` varchar(250) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `cep` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `situacao` enum('Aberto','Enviado','Entregue') DEFAULT 'Aberto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `FK_cpf_cliente` (`cpf`);

ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE clientes ADD UNIQUE KEY email_unico (email);
