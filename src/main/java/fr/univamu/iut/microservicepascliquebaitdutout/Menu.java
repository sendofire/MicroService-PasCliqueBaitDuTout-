package fr.univamu.iut.microservicepascliquebaitdutout;

import jakarta.persistence.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@Entity
@Table(name = "menu")
public class Menu {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    private String nom;
    private String createur;

    @Temporal(TemporalType.DATE)
    private Date dateCreation;

    @Temporal(TemporalType.DATE)
    private Date dateMaj;

    @ElementCollection
    @CollectionTable(name = "menu_plat", joinColumns = @JoinColumn(name = "menu_id"))
    @Column(name = "plat_id")
    private List<Integer> platIds = new ArrayList<>();

    public int getId() { return id; }
    public String getNom() { return nom; }
    public String getCreateur() { return createur; }
    public Date getDateCreation() { return dateCreation; }
    public Date getDateMaj() { return dateMaj; }
    public List<Integer> getPlatIds() { return platIds; }

    public void setId(int id) { this.id = id; }
    public void setNom(String nom) { this.nom = nom; }
    public void setCreateur(String createur) { this.createur = createur; }
    public void setDateCreation(Date dateCreation) { this.dateCreation = dateCreation; }
    public void setDateMaj(Date dateMaj) { this.dateMaj = dateMaj; }
    public void setPlatIds(List<Integer> platIds) { this.platIds = platIds; }
}